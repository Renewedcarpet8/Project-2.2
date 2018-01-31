import org.xml.sax.InputSource;

import javax.xml.parsers.SAXParser;
import javax.xml.parsers.SAXParserFactory;

import java.io.*;

import java.net.ServerSocket;
import java.net.Socket;
import java.net.SocketTimeoutException;

/**
 * Created by Jan Hendrik Haanstra on 1/28/2018.
 */
public class Listener extends Thread{
    private ServerSocket serverSocket;
    private int num_of_messages = 0;
    private boolean running = true;

    public Listener(int port) throws IOException {
        serverSocket = new ServerSocket(port);
        serverSocket.setSoTimeout(1000);
    }

    public void run() {
        while (running) {
            // Accept a connection
            try {
                System.out.println("Waiting for client on port " + serverSocket.getLocalPort() + "...");
                Socket connectionSocket = serverSocket.accept();
                BufferedReader reader = new BufferedReader(new InputStreamReader(connectionSocket.getInputStream()));
                Message message = new Message(reader, num_of_messages);
                num_of_messages++;
                message.start();
            } catch (SocketTimeoutException e) {
                System.out.println("Time out!");
            } catch (IOException e) {
                e.printStackTrace();
            }

        }
    }
}