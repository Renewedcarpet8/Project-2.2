import java.io.*;
import java.nio.charset.Charset;
import java.nio.file.Files;
import java.nio.file.Path;
import java.nio.file.Paths;
import java.text.DateFormat;
import java.text.SimpleDateFormat;
import java.time.LocalDate;
import java.time.LocalTime;
import java.util.Date;
import java.util.EmptyStackException;
import java.util.Stack;

/**
     * Created by Jan Hendrik Haanstra on 1/28/2018.
     */
    public class MeasurementLogger {
        private Charset charset = Charset.forName("US-ASCII");
        private Path file = Paths.get("data/testdata.csv");
        private Stack<Measurement> queue = new Stack<>();
        private boolean running;
        private BufferedWriter writer;
        String currentPath;

        public MeasurementLogger() {
            this.currentPath = "data/" + new SimpleDateFormat("yyyy/MM/dd/HH").format(new Date()) + ".csv";
            updateBufferedWriter();
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

        public synchronized void addToQueue(Measurement measurement) {
            queue.push(measurement);
        }

        private synchronized Stack<Measurement> getQueue() {
            return queue;
        }

        public synchronized void writeToLog(Measurement measurement) {
            String location = "data/" + measurement.getYear() + "/" + measurement.getMonth() + "/" + measurement.getDay() + "/" + measurement.getHour() + ".csv";
            try {
                if (!location.equals(currentPath)) {
                    this.currentPath = location;
                    updateBufferedWriter();
                }
                //System.out.println(measurement.getDataString());
                writer.write(measurement.getDataString() + "\n");
            } catch (IOException e) {
                // TODO Error Logging
                e.printStackTrace();
            }
        }

        private void updateBufferedWriter() {
            try {
                File file = new File(currentPath);
                file.getParentFile().mkdirs();
                file.createNewFile();
            } catch (IOException e) {
                // TODO Error Logging
            }
            try  {
                writer = new BufferedWriter(new FileWriter(currentPath, true));
            } catch (IOException e) {
                // TODO Error Logging
            }
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
