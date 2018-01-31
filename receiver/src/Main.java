import java.io.IOException;

public class Main {

    public static void main(String[] args) {
        int port = 7789;
        try {
            Listener t = new Listener(port);
            t.start();
        } catch (IOException e) {
            e.printStackTrace();
        }
    }
}
