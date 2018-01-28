import java.io.BufferedReader;
import java.io.IOException;

/**
 * Created by Jan Hendrik Haanstra on 1/28/2018.
 */
public class DataHandler extends Thread {
    private BufferedReader reader;
    private String message = "";

    public DataHandler(BufferedReader reader) {
        this.reader = reader;
    }

    public void run() {
        try {
            String inputLine;
            while((inputLine = reader.readLine()) != null) {
                message = message + inputLine;
                System.out.println(inputLine);
            }
            System.out.println(message);
        } catch (IOException e) {
            // TODO: Create an error log file
            e.printStackTrace();
        } finally {
            try {
                reader.close();
            } catch (IOException e) {
                // TODO: Create an error log file
                e.printStackTrace();
            }
        }
    }
}
