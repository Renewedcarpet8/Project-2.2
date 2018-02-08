import java.io.*;
import java.util.HashMap;

    /**
     * Logger class that logs the measurements to the correct file and manages the files.
     *
     * @author Jan Hendrik Haanstra
     * @version 1.1
     * @since 2018-01-28
     */
    public class MeasurementLogger {
        String currentPath;
        private HashMap<String, MeasurementBufferedWriter> writerHashMap = new HashMap<>();

        public MeasurementLogger() {
            this.currentPath = "";
        }

        /**
         * Writes a measurement to the correct log and maintains the writerHashMap.
         *
         * First, the writerHashMap gets checked if it already contains a BufferedWriter of the correct country.
         * Then if needed, the writerHashMap gets edited based on the current measurement. After that, the measurement
         * get written to the correct file.
         *
         * @param measurement Measurement to write to the log.
         */
        public synchronized void writeToLog(Measurement measurement) {
            String location = measurement.getYear() + "/" + measurement.getMonth() + "/" + measurement.getDay() + "/" + measurement.getHour() + "/" + measurement.getCountry() + ".csv";
            String country = measurement.getCountry();
            try {
                if (writerHashMap.containsKey(country)) {
                    if (!location.equals(writerHashMap.get(country).getLocation())) {
                        writerHashMap.get(country).close();
                        createFile(location);
                        writerHashMap.put(country, new MeasurementBufferedWriter(location));
                    }
                } else {
                    createFile(location);
                    writerHashMap.put(country, new MeasurementBufferedWriter(location));
                }
                writerHashMap.get(country).write(measurement.getDataString());
            } catch (IOException e) {
                // TODO Error Logging
                e.printStackTrace();
            }
        }

        /**
         * Checks if a file and path already exist and creates them if needed.
         *
         * @param location Location to check
         */
        private void createFile(String location) throws IOException {
            File file = new File(location);
            file.getParentFile().mkdirs();
            file.createNewFile();
        }
}
