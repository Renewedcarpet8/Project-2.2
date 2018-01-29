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
public class Listener extends Thread {
    private ServerSocket serverSocket;
    private int num_of_messages = 0;
    private boolean running = true;

    public Listener(int port) throws IOException {
        serverSocket = new ServerSocket(port);
        serverSocket.setSoTimeout(1000);
    }

    public void run() {
        try {
            File file = new File("data/output.xml");
            SAXParserFactory factory = SAXParserFactory.newInstance();
            SAXParser saxParser = factory.newSAXParser();
            XMLParser xmlParser = new XMLParser();
            saxParser.parse(file, xmlParser);
        } catch (Exception e) {
            // TODO: Error logging
            e.printStackTrace();
        }
        /*while (running) {
            // Accept a connection
            try {
                System.out.println("Waiting for client on port " + serverSocket.getLocalPort() + "...");
                Socket connectionSocket = serverSocket.accept();

                BufferedReader reader = new BufferedReader(new InputStreamReader(connectionSocket.getInputStream()));
                String inputLine;
                try {
                    while((inputLine = reader.readLine()) != null) {
                        try {
                            SAXParserFactory factory = SAXParserFactory.newInstance();
                            SAXParser saxParser = factory.newSAXParser();
                            XMLParser xmlParser = new XMLParser();
                            saxParser.parse(new InputSource(new StringReader(inputLine)), xmlParser);
                        } catch (Exception e) {
                            // TODO: Error logging
                            e.printStackTrace();
                        }

                    }
                } catch (IOException e) {
                    e.printStackTrace();
                } finally {
                    try {
                        reader.close();
                    } catch (IOException e) {
                        e.printStackTrace();
                    }
                }

            } catch (SocketTimeoutException e) {
                System.out.println("Time out!");
            } catch (IOException e) {
                e.printStackTrace();
            }

        }*/
    }
}