import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStreamReader;
import java.net.Socket;
import java.time.LocalDate;
import java.time.LocalTime;
import java.util.ArrayList;
import java.util.HashMap;
import java.util.LinkedList;
import java.util.Queue;
import java.util.concurrent.ConcurrentHashMap;
import java.util.regex.Matcher;
import java.util.regex.Pattern;

/**
 * Parser class that handles clusters and parses the incoming data.
 *
 * @author Jan Hendrik Haanstra
 * @version 1.0
 * @since 2018-01-28
 */
public class MeasurementParser extends Thread {
    private int thread_number;
    private Measurement measurement;
    private Socket client;
    private Pattern pattern = Pattern.compile("^\\<([a-zA-Z_]*)\\>(.+)\\<\\/([a-zA-Z_]*)\\>$");
    private Boolean parsing = false;
    private String currentLine;
    private Measurement last;
    private Measurement first;
    private ConcurrentHashMap<Integer, Queue<Measurement>> validity;
    private HashMap<String, ArrayList<String>> countries;
    private MeasurementLogger logger;

    /**
     * Creates a MeasurementParser object and provides it with a client cluster, thread number en logger object
     *
     * @param client Socket of the client cluster that the parser object is going to handle
     * @param thread_number Thread number assigned by the listener
     * @param logger Logger object the logs the parsed data
     */
    public MeasurementParser(Socket client, int thread_number, MeasurementLogger logger, HashMap<String, ArrayList<String>> countries) {
        this.client = client;
        this.thread_number = thread_number;
        this.logger = logger;
        this.countries = countries;
        validity = new ConcurrentHashMap<>();
    }

    /**
     *
     */
    @Override
    public void run() {
        System.out.println("Thread" + thread_number + " starting");
        BufferedReader in;
        try{
            in = new BufferedReader(new InputStreamReader(client.getInputStream()));
            while((currentLine = in.readLine()) != null) {
                if (currentLine.trim().equalsIgnoreCase("<MEASUREMENT>")) {
                    measurement = new Measurement();
                    parsing = true;
                } else if (currentLine.trim().equalsIgnoreCase("</MEASUREMENT>")) {
                    if (checkValidity())
                        logger.writeToLog(measurement);
                } else if (parsing)
                    readTag();
            }
        } catch (IOException e) {
            // TODO: error logging
        }

        System.out.println("Thread " +  thread_number + " exiting.");

    }

    /**
     * Reads the current line and applies it to the current measurement object.
     *
     * It trims the current line and mathes it with the regex. Based on the content between the tags,
     * the value gets set to the correct attribute of the current measurement. If the tag does not match,
     * the function returns.
     */
    private void readTag() {
        Matcher matcher = pattern.matcher(currentLine.trim());
        if (matcher.find()) {
            if (matcher.group(1).equalsIgnoreCase(matcher.group(3))) {
                if (matcher.group(1).equalsIgnoreCase("STN")) {
                    measurement.setStation(Integer.parseInt(matcher.group(2)));
                    for (String key : countries.keySet()) {
                        if (countries.get(key).contains(matcher.group(2))) {
                            measurement.setCountry(key);
                        }
                    }

                }
                else if (matcher.group(1).equalsIgnoreCase("DATE")) {
                    String[] dateString = matcher.group(2).split("-");
                    measurement.setDate(LocalDate.of(Integer.parseInt(dateString[0]), Integer.parseInt(dateString[1]), Integer.parseInt(dateString[2])));
                } else if (matcher.group(1).equalsIgnoreCase("TIME")) {
                    String[] timeString = matcher.group(2).split(":");
                    measurement.setTime(LocalTime.of(Integer.parseInt(timeString[0]), Integer.parseInt(timeString[1]), Integer.parseInt(timeString[2])));
                } else if (matcher.group(1).equalsIgnoreCase("TEMP"))
                    measurement.setTemperature(Float.parseFloat(matcher.group(2)));
                else if (matcher.group(1).equalsIgnoreCase("DEWP"))
                    measurement.setDewpoint(Float.parseFloat(matcher.group(2)));
                else if (matcher.group(1).equalsIgnoreCase("STP"))
                    measurement.setPressure_station(Float.parseFloat(matcher.group(2)));
                else if (matcher.group(1).equalsIgnoreCase("SLP"))
                    measurement.setPressure_sea(Float.parseFloat(matcher.group(2)));
                else if (matcher.group(1).equalsIgnoreCase("VISIB"))
                    measurement.setVisibility(Float.parseFloat(matcher.group(2)));
                else if (matcher.group(1).equalsIgnoreCase("WDSP"))
                    measurement.setWind(Float.parseFloat(matcher.group(2)));
                else if (matcher.group(1).equalsIgnoreCase("PRCP"))
                    measurement.setRainfall(Float.parseFloat(matcher.group(2)));
                else if (matcher.group(1).equalsIgnoreCase("SNDP"))
                    measurement.setSnowfall(Float.parseFloat(matcher.group(2)));
                else if (matcher.group(1).equalsIgnoreCase("FRSHTT"))
                    measurement.setFlags(matcher.group(2));
                else if (matcher.group(1).equalsIgnoreCase("CLDC"))
                    measurement.setCloud_cover(Float.parseFloat(matcher.group(2)));
                else if (matcher.group(1).equalsIgnoreCase("WNDDIR"))
                    measurement.setWind_direction(Integer.parseInt(matcher.group(2)));
            }
        }
    }

    /**
     * Checks if the current measurement is valid or not.
     *
     * If this is the first measurement, this method only checks if the values of the measurement are still their
     * default values or not. If so, a correct calculation can not yet be made and the measurement gets discarded.
     * If this is not the first measurement, this method calculates the average for each attribute and compares
     * if the current measurement is default or more than 20% off the average of the last 30 measurements. If this is
     * the case, the difference between the first and last measurement gets divided by 30 or the amount of measurements
     * so far. This gets added by the last measurement for extrapolation. Finally the Queue with the last 30
     * measurements gets updated.
     *
     * @return If the measurement is allowed to be used for storage or not.
     */
    private boolean checkValidity() {
        // TODO: Error logging after every if about the error type in the data
        // TODO: Timezone + 1 (ZoneId.of("America/Los_Angeles))
        int   stationId = measurement.getStation();
        if (measurement.getCountry() == null) {
            System.out.println("INVALID");
            return false;
        }

        if (validity.containsKey(measurement.getStation())) {
            float averageTemperature = 0;
            float averageDewpoint = 0;
            float averagePressure_station = 0;
            float averagePressure_sea = 0;
            float averageVisibility = 0;
            float averageWind = 0;
            float averageRainfall = 0;
            float averageSnowfall = 0;
            float averageCloud_cover = 0;
            int   averageWind_direction = 0;

            Queue<Measurement> queue = validity.get(stationId);
            first = queue.peek();
            int total = queue.size();

            for (int i = 0; i < total; i++) {
                Measurement current = queue.remove();
                if (i == queue.size())
                    last = current;

                averageTemperature += current.getTemperature();
                averageDewpoint += current.getDewpoint();
                averagePressure_station += current.getPressure_station();
                averagePressure_sea += current.getPressure_sea();
                averageVisibility += current.getVisibility();
                averageWind += current.getWind();
                averageRainfall += current.getRainfall();
                averageSnowfall += current.getSnowfall();
                averageCloud_cover += current.getCloud_cover();
                averageWind_direction += current.getWind_direction();
                queue.add(current);
            }

            averageTemperature /= total;
            averageDewpoint /= total;
            averagePressure_station /= total;
            averagePressure_sea /= total;
            averageVisibility /= total;
            averageWind /= total;
            averageRainfall /= total;
            averageSnowfall /= total;
            averageCloud_cover /= total;
            averageWind_direction /= total;

            if (measurement.getTemperature() >= 10001 || measurement.getTemperature() > averageTemperature * 1.2 || measurement.getTemperature() < averageTemperature * 1.2)
                measurement.setTemperature(last.getTemperature() + (first.getTemperature() - last.getTemperature() / total));

            if (measurement.getDewpoint() >= 10001 || measurement.getDewpoint() > averageDewpoint * 1.2 || measurement.getDewpoint() < averageDewpoint * 1.2)
                measurement.setDewpoint(last.getDewpoint() + (first.getDewpoint() - last.getDewpoint() / total));

            if (measurement.getPressure_station() >= 10001 || measurement.getPressure_station() > averagePressure_station * 1.2 || measurement.getPressure_station() < averagePressure_station * 1.2)
                measurement.setPressure_station(last.getPressure_station() + (first.getPressure_station() - last.getPressure_station() / total));

            if (measurement.getPressure_sea() >= 10001 || measurement.getPressure_sea() > averagePressure_sea * 1.2 || measurement.getPressure_sea() < averagePressure_sea * 1.2)
                measurement.setPressure_sea(last.getPressure_sea() + (first.getPressure_sea() - last.getPressure_sea() / total));

            if (measurement.getVisibility() >= 1001 || measurement.getVisibility() > averageVisibility * 1.2 || measurement.getVisibility() < averageVisibility * 1.2)
                measurement.setVisibility(last.getVisibility() + (first.getVisibility() - last.getVisibility() / total));

            if (measurement.getWind() >= 1001 || measurement.getWind() > averageWind * 1.2 || measurement.getWind() < averageWind * 1.2)
                measurement.setWind(last.getWind() + (first.getWind() - last.getWind() / total));

            if (measurement.getRainfall() >= 1001 || measurement.getRainfall() > averageRainfall * 1.2 || measurement.getRainfall() < averageRainfall * 1.2)
                measurement.setRainfall(last.getRainfall() + (first.getRainfall() - last.getRainfall() / total));

            if (measurement.getSnowfall() >= 10001 || measurement.getSnowfall() > averageSnowfall * 1.2 || measurement.getSnowfall() < averageSnowfall * 1.2)
                measurement.setSnowfall(last.getSnowfall() + (first.getSnowfall() - last.getSnowfall() / total));

            if (measurement.getFlags() == null)
                measurement.setFlags(last.getFlags());

            if (measurement.getCloud_cover() >= 101 || measurement.getCloud_cover() > averageCloud_cover * 1.2 || measurement.getCloud_cover() < averageCloud_cover * 1.2)
                measurement.setCloud_cover(last.getCloud_cover() + (first.getCloud_cover() - last.getCloud_cover() / total));

            if (measurement.getWind_direction() >= 361 || measurement.getWind_direction() > averageWind_direction * 1.2 || measurement.getWind_direction() < averageWind_direction * 1.2)
                measurement.setWind_direction(last.getWind_direction() + (first.getWind_direction() - last.getWind_direction() / total));

            if (total == 30)
                validity.get(measurement.getStation()).remove();
            validity.get(stationId).add(measurement);
            return true;
        }
        if (measurement.getTemperature() >= 10001 ||
                measurement.getDewpoint() >= 10001 ||
                measurement.getPressure_station() >= 10001 ||
                measurement.getPressure_sea() >= 10001 ||
                measurement.getVisibility() >= 1001 ||
                measurement.getWind() >= 1001 ||
                measurement.getRainfall() >= 1001 ||
                measurement.getSnowfall() >= 10001 ||
                measurement.getFlags() == null ||
                measurement.getCloud_cover() >= 101 ||
                measurement.getWind_direction() >= 361) return false;

        validity.put(stationId, new LinkedList<>());
        validity.get(stationId).add(measurement);
        return true;
    }
}