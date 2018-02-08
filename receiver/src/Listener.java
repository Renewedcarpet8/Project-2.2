import java.io.*;
import java.net.ServerSocket;
import java.net.Socket;
import java.nio.charset.Charset;
import java.nio.file.Files;
import java.nio.file.Path;
import java.nio.file.Paths;
import java.util.ArrayList;
import java.util.HashMap;
import java.util.concurrent.ExecutorService;
import java.util.concurrent.Executors;

/**
 * Listener class that receives and handles all incoming messages to different
 * parser threads
 *
 * @author Jan Hendrik Haanstra, Bessel Bode
 * @version 1.1
 * @since 2018-01-28
 */
public class Listener extends Thread{
    private ServerSocket serverSocket;
    private int num_of_messages = 0;
    private boolean running = true;
    private ExecutorService executor;
    private MeasurementLogger logger = new MeasurementLogger();
    private HashMap<String, ArrayList<String>> countries = new HashMap<>();
    private Charset charset = Charset.forName("US-ASCII");
    private Path file = Paths.get("data/stations.csv");

    /**
     * Creates a socket that listens for incoming messages. Also creates a
     * threadpool executor for managing parser threads.
     *
     * @param port portnumber of the listener
     * @param threads number of threads
     */
    public Listener(int port, int threads) throws IOException {
        try (BufferedReader reader = Files.newBufferedReader(file, charset)){
            String line;
            while ((line = reader.readLine()) != null) {
                String[] data = line.split("%");
                String country = data[2];
                String station_id = data[0];
                if (!countries.containsKey(country))
                    countries.put(country, new ArrayList<>());
                countries.get(country).add(station_id);
            }
        } catch (IOException x) {
            //TODO: Error Logging
        }
        
        serverSocket = new ServerSocket(port);
        // Create a thread pool of n threads
        executor = Executors.newFixedThreadPool(threads);
    }

    /**
     * Run function for the listener threads
     *
     * For every cluster, there will be a parser thread started. These threads are handled by the
     * threadpool executor.
     */
    public void run() {
        while (running) {
            try {
                // Listen on the port for incoming messages
                System.out.println("Waiting for client on port " + serverSocket.getLocalPort() + "...");
                Socket client = serverSocket.accept();
                num_of_messages++;

                // Get the incoming data and create a thread using it
                Thread parser = new MeasurementParser(client, num_of_messages, logger, countries);

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