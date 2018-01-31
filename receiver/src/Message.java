import org.xml.sax.InputSource;

import javax.xml.parsers.SAXParser;
import javax.xml.parsers.SAXParserFactory;
import java.io.BufferedReader;
import java.io.IOException;
import java.io.StringReader;

public class Message extends Thread {
    private BufferedReader reader;
    private int threadNumber;

    public Message(BufferedReader reader, int threadNumber) {
        this.reader= reader;
        this.threadNumber = threadNumber;
    }

    @Override
    public void run() {
        String inputLine;
        String xml = "";
        try {
            while((inputLine = reader.readLine()) != null) {
                System.out.println("Thread " + threadNumber + ": " + inputLine);
                xml += inputLine;
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


        try {
            SAXParserFactory factory = SAXParserFactory.newInstance();
            SAXParser saxParser = factory.newSAXParser();
            XMLParser xmlParser = new XMLParser();
            System.out.println("Thread " + threadNumber + " just got: ");
            System.out.println(xml);
            saxParser.parse(new InputSource(new StringReader(xml)), xmlParser);

            //System.out.println("Thread " + threadNumber + " just parsed: " + xmlParser.getMeasurements());
        } catch (Exception e) {
            // TODO: Error logging
            e.printStackTrace();
        }
        System.out.println("Thread " +  threadNumber + " exiting.");
    }
}

/*try {
    File file = new File("data/output.xml");
    SAXParserFactory factory = SAXParserFactory.newInstance();
    SAXParser saxParser = factory.newSAXParser();
    XMLParser xmlParser = new XMLParser();
    saxParser.parse(file, xmlParser);

    System.out.println("this is get" + xmlParser.getMeasurements());
} catch (Exception e) {
    // TODO: Error logging
    e.printStackTrace();
}*/
