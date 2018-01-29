import java.io.BufferedReader;
import java.io.BufferedWriter;
import java.io.FileWriter;
import java.io.IOException;
import java.nio.charset.Charset;
import java.nio.file.Files;
import java.nio.file.Path;
import java.nio.file.Paths;
import java.time.LocalDateTime;
import java.time.format.DateTimeFormatter;

/**
 * Created by Jan Hendrik Haanstra on 1/28/2018.
 */
public class DataLog {
    private final DateTimeFormatter dateTimeFormatter = DateTimeFormatter.ofPattern("yyyy:MM:dd-HH:mm:ss");
    private Charset charset = Charset.forName("US-ASCII");
    private Path file = Paths.get("data/testdata.csv");

    public DataLog() {
        writeToLog(parseDataString(parseMeassurement("2017:09:13-15:59:46,123456,60.1,58.1,1034.5,1337.6,123.7,10.8,11.28,11.1,010101,87.4,342")));
    }

    public void readLog() {
        try (BufferedReader reader = Files.newBufferedReader(file, charset)){
            String line;
            while ((line = reader.readLine()) != null) {
                System.out.println(parseMeassurement(line).getDatetime());
            }
        } catch (IOException x) {
            System.err.println(x);
        }
    }

    public void writeToLog(String toWrite) {
        try (BufferedWriter writer = new BufferedWriter(new FileWriter("data/testdata.csv", true))) {
            writer.write(toWrite + "\n");
        } catch (IOException e) {
            // TODO: Error logging
            e.printStackTrace();
        }

    }

    private String parseDataString(Measurement measurement) {
        return measurement.getDatetime().format(dateTimeFormatter) + "," + measurement.getStation() + "," + measurement.getTemperature()
                + "," + measurement.getDewpoint() + "," + measurement.getPressure_station() + "," + measurement.getPressure_sea()
                + "," + measurement.getVisibility() + "," + measurement.getWind() + "," + measurement.getRainfall() + "," +
                measurement.getSnowfall() + "," + measurement.getFlags() + "," + measurement.getCloud_cover() + "," + measurement.getWind_direction();
    }

    private Measurement parseMeassurement(String line) {
        String[] parts = line.split(",");
        LocalDateTime dateTime = LocalDateTime.parse(parts[0], dateTimeFormatter);
        int station = Integer.parseInt(parts[1]);
        float temperature = Float.parseFloat(parts[2]);
        float dewpoint = Float.parseFloat(parts[3]);
        float pressure_station = Float.parseFloat(parts[4]);
        float pressure_sea = Float.parseFloat(parts[5]);
        float visibility = Float.parseFloat(parts[6]);
        float wind = Float.parseFloat(parts[7]);
        float rainfall = Float.parseFloat(parts[8]);
        float snowfall = Float.parseFloat(parts[9]);
        String flags = parts[10];
        float cloud_cover = Float.parseFloat(parts[11]);
        int wind_direction = Integer.parseInt(parts[12]);
        return new Measurement(dateTime, station, temperature, dewpoint, pressure_station, pressure_sea, visibility, wind, rainfall, snowfall, flags, cloud_cover, wind_direction);
    }
}
                                                                                            