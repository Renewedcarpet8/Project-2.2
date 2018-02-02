import java.io.BufferedReader;
import java.io.IOException;
import java.time.LocalDate;
import java.time.LocalTime;
import java.util.ArrayList;
import java.util.regex.Matcher;
import java.util.regex.Pattern;

public class MeasurementParser extends Thread {
    private BufferedReader reader;
    private int thread_number;
    ArrayList<Measurement> measurements = new ArrayList<>();
    Measurement measurement;
    Pattern pattern;
    Boolean parsing = false;
    private String currentLine;

    public MeasurementParser(BufferedReader reader, int thread_number) {
        this.reader= reader;
        this.thread_number = thread_number;
        pattern = Pattern.compile("^\\<([a-zA-Z_]*)\\>(.+)\\<\\/([a-zA-Z_]*)\\>$");
    }

    @Override
    public void run() {
        System.out.println("Thread" + thread_number + " starting");
        try {
            while((currentLine = reader.readLine()) != null) {
                if (parsing)
                    readTag();
                else if (currentLine.trim().equalsIgnoreCase("<MEASUREMENT>"))
                    measurement = new Measurement();
                else if (currentLine.trim().equalsIgnoreCase("</MEASUREMENT>")) {
                    System.out.println(measurement);
                    measurements.add(measurement);
                }

            }
        } catch (IOException e) {
            e.printStackTrace();
        } finally {
            try {
                reader.close();
            } catch (IOException e) {
                e.printStackTrace();
            }
        }

        // Update CSV here

        System.out.println("Thread " +  thread_number + " exiting.");
    }

    private void readTag() {
        Matcher matcher = pattern.matcher(currentLine.trim());
        if (matcher.find()) {
            if (matcher.group(1).equalsIgnoreCase(matcher.group(3))) {
                if (matcher.group(1).equalsIgnoreCase("STN"))
                    measurement.setStation(Integer.parseInt(matcher.group(2)));
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
}