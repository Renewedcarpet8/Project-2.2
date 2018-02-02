import java.io.*;
import java.nio.charset.Charset;
import java.nio.file.Files;
import java.nio.file.Path;
import java.nio.file.Paths;
import java.time.LocalDate;
import java.time.LocalTime;
import java.util.Stack;

/**
     * Created by Jan Hendrik Haanstra on 1/28/2018.
     */
    public class MeasurementLogger extends Thread {
        private Charset charset = Charset.forName("US-ASCII");
        private Path file = Paths.get("data/testdata.csv");
        private Stack<Measurement> queue = new Stack<>();

        public MeasurementLogger() {}

        @Override
        public void run() {
            while (true) {
                writeToLog(queue.pop());
            }
        }

        public void readLog() {
            try (BufferedReader reader = Files.newBufferedReader(file, charset)){
                String line;
                while ((line = reader.readLine()) != null) {
                    System.out.println(parseMeassurement(line));
                }
            } catch (IOException x) {
                System.err.println(x);
            }
        }

        public void writeToLog(Measurement measurement) {
            String location = "data/" + measurement.getYear() + "/" + measurement.getMonth() + "/" + measurement.getDay() + measurement.getHour() + ".csv";
            File file = new File(location);
            file.mkdirs();

            try (BufferedWriter writer = new BufferedWriter(new FileWriter(location, true))) {
                writer.write(measurement.getDataString() + "\n");
            } catch (IOException e) {
                // TODO: Error logging
                e.printStackTrace();
            }
        }

        private String parseDataString(Measurement measurement) {
            return measurement.getDate() + "," + measurement.getTime() + "," + measurement.getStation() + "," + measurement.getTemperature()
                    + "," + measurement.getDewpoint() + "," + measurement.getPressure_station() + "," + measurement.getPressure_sea()
                    + "," + measurement.getVisibility() + "," + measurement.getWind() + "," + measurement.getRainfall() + "," +
                    measurement.getSnowfall() + "," + measurement.getFlags() + "," + measurement.getCloud_cover() + "," + measurement.getWind_direction();
        }

        private Measurement parseMeassurement(String line) {
            // TODO: Error logging
            String[] parts = line.split(",");
            // Split the date by "-" and parse the results to integers in a LocalDate
            String[] dateString = parts[0].split("-");
            LocalDate date = LocalDate.of(Integer.parseInt(dateString[0]), Integer.parseInt(dateString[1]), Integer.parseInt(dateString[2]));

            // Split the time by ":" and parse the results to integers in a LocalTime
            String[] timeString = parts[1].split(":");
            LocalTime time = LocalTime.of(Integer.parseInt(timeString[0]), Integer.parseInt(timeString[1]), Integer.parseInt(timeString[2]));

            // Parse the rests of the parts to the desired type and create a new Measurement object
            int station = Integer.parseInt(parts[2]);
            float temperature = Float.parseFloat(parts[3]);
            float dewpoint = Float.parseFloat(parts[4]);
            float pressure_station = Float.parseFloat(parts[5]);
            float pressure_sea = Float.parseFloat(parts[6]);
            float visibility = Float.parseFloat(parts[7]);
            float wind = Float.parseFloat(parts[8]);
            float rainfall = Float.parseFloat(parts[9]);
            float snowfall = Float.parseFloat(parts[10]);
            String flags = parts[11];
            float cloud_cover = Float.parseFloat(parts[12]);
            int wind_direction = Integer.parseInt(parts[13]);
            return new Measurement(date, time, station, temperature, dewpoint, pressure_station, pressure_sea, visibility, wind, rainfall, snowfall, flags, cloud_cover, wind_direction);
        }
}
