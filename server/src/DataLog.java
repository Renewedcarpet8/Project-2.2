import java.io.BufferedReader;
import java.io.BufferedWriter;
import java.io.IOException;
import java.nio.charset.Charset;
import java.nio.file.Files;
import java.nio.file.Path;
import java.nio.file.Paths;

/**
 * Created by Jan Hendrik Haanstra on 1/28/2018.
 */
public class DataLog {
    private Charset charset = Charset.forName("US-ASCII");
    private Path file = Paths.get("data/weatherdata.txt");

    public DataLog() {

    }

    public void readLog() {
        try (BufferedReader reader = Files.newBufferedReader(file, charset)){
            String line = null;
            while ((line = reader.readLine()) != null)
                System.out.println(line);
        } catch (IOException x) {
            System.err.println(x);
        }
    }

    public void writeToLog(String toWrite) {
        try (BufferedWriter writer = Files.newBufferedWriter(file, charset)) {
            //writer.newLine(toWrite, 0, toWrite.length());
        } catch (IOException x) {
            System.err.println(x);
        }
    }
}
