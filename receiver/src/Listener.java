import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStreamReader;
import java.net.ServerSocket;
import java.net.Socket;
import java.net.SocketTimeoutException;

/**
 * Created by Jan Hendrik Haanstra on 1/28/2018.
 */
public class Listener extends Thread {
    private ServerSocket serverSocket;
    private int num_of_messages = 0;

    public Server(int port) throws IOException {
        serverSocket = new ServerSocket(port);
        serverSocket.setSoTimeout(10000);
    }

    public void run() {
        while (true) {
            // Accept a connection
            try {
                System.out.println("Waiting for client on port " + serverSocket.getLocalPort() + "...");
                Socket connectionSocket = serverSocket.accept();

                BufferedReader reader = new BufferedReader(new InputStreamReader(connectionSocket.getInputStream()));

                new DataHandler(reader).start();
                //connectionSocket.close();
                // Deal with the connection (do this in a different thread)

                /*System.out.println("Just connected to " + server.getRemoteSocketAddress());
                DataInputStream in = new DataInputStream(server.getInputStream());

                System.out.println(in.readUTF());
                DataOutputStream out = new DataOutputStream(server.getOutputStream());
                out.writeUTF("Thank you for connecting to " + server.getLocalSocketAddress()
                        + "\nGoodbye!");
                server.close();*/

            } catch (SocketTimeoutException e) {
                System.out.println("Time out!");
            } catch (IOException e) {
                e.printStackTrace();
            }

        }
    }
}
