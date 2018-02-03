import java.io.IOException;

public class Main {

    public static void main(String[] args) {
        int port = 7789;
        int threads = 800;

        try {
            Listener t = new Listener(port, threads);
            t.start();
        } catch (IOException e) {
            e.printStackTrace();
        }
    }
}
