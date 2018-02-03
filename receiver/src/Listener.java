import java.io.*;
import java.net.ServerSocket;
import java.net.Socket;
import java.net.SocketTimeoutException;
import java.util.concurrent.ExecutorService;
import java.util.concurrent.Executors;

/**
 * Created by Jan Hendrik Haanstra on 1/28/2018.
 */
public class Listener extends Thread{
    private ServerSocket serverSocket;
    private int num_of_messages = 0;
    private boolean running = true;
    private ExecutorService executor;
    private MeasurementLogger logger = new MeasurementLogger();

    public Listener(int port, int threads) throws IOException {
        serverSocket = new ServerSocket(port);
        // Create a thread pool of n threads
        executor = Executors.newFixedThreadPool(threads);
    }

    public void run() {
        while (running) {
            try {
                // Listen on the port for incoming messages
                System.out.println("Waiting for client on port " + serverSocket.getLocalPort() + "...");
                Socket client = serverSocket.accept();
                num_of_messages++;

                // Get the incoming data and create a thread using it
                Thread parser = new MeasurementParser(client, num_of_messages, logger);

                // Pass the thread over to the executor
                executor.execute(parser);
            } catch (IOException e) {
                e.printStackTrace();
            }
        }

        executor.shutdown();
        System.out.println("Socket on port " + serverSocket.getLocalPort() + " closed");
    }
}