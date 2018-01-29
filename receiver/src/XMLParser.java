import org.xml.sax.Attributes;
import org.xml.sax.SAXException;
import org.xml.sax.helpers.DefaultHandler;

import java.util.List;

public class XMLParser extends DefaultHandler {
    private List<Measurement> measurements;
    private Measurement measurement;
    private boolean date = false;
    private boolean time = false;
    private boolean station = false;
    private boolean temperature = false;
    private boolean dewpoint = false;
    private boolean pressure_station = false;
    private boolean pressure_sea = false;
    private boolean visibility = false;
    private boolean wind = false;
    private boolean rainfall = false;
    private boolean snowfall = false;
    private boolean flags = false;
    private boolean cloud_cover = false;
    private boolean wind_direction = false;

    public void startElement(String uri, String localName, String tag, Attributes attributes) throws SAXException {
        if (tag.equalsIgnoreCase("MEASUREMENT"))
            measurement = new Measurement();
        else if (tag.equalsIgnoreCase("STN"))
            station = true;
        else if (tag.equalsIgnoreCase("DATE"))
            date = true;
        else if (tag.equalsIgnoreCase("TIME"))
            time = true;
        else if (tag.equalsIgnoreCase("TEMP"))
            temperature = true;
        else if (tag.equalsIgnoreCase("DEWP"))
            dewpoint = true;
        else if (tag.equalsIgnoreCase("STP"))
            pressure_station = true;
        else if (tag.equalsIgnoreCase("SLP"))
            pressure_sea = true;
        else if (tag.equalsIgnoreCase("VISIB"))
            visibility = true;
        else if (tag.equalsIgnoreCase("WDSP"))
            wind = true;
        else if (tag.equalsIgnoreCase("PRCP"))
            rainfall = true;
        else if (tag.equalsIgnoreCase("SNDP"))
            snowfall = true;
        else if (tag.equalsIgnoreCase("FRSHTT"))
            flags = true;
        else if (tag.equalsIgnoreCase("CLDC"))
            cloud_cover = true;
        else if (tag.equalsIgnoreCase("WNDDIR"))
            wind_direction = true;
    }

    @Override
    public void endElement(String uri, String localName, String tag) throws SAXException {
        if (tag.equalsIgnoreCase("MEASUREMENT"))
            System.out.println(measurement);
    }

    @Override
    public void characters(char ch[], int start, int length) throws SAXException {
        if (date) {
            System.out.println(date);
            date = false;
        } if (time) {
            System.out.println(time);
            time = false;
        } if (station) {
            measurement.setStation(Integer.parseInt(new String(ch, start, length)));
            station = false;
        } if (temperature) {
            measurement.setTemperature(Float.parseFloat(new String(ch, start, length)));
            temperature = false;
        } if (dewpoint) {
            measurement.setDewpoint(Float.parseFloat(new String(ch, start, length)));
            dewpoint = false;
        } if (pressure_station) {
            measurement.setPressure_station(Float.parseFloat(new String(ch, start, length)));
            pressure_station = false;
        } if (pressure_sea) {
            measurement.setPressure_sea(Float.parseFloat(new String(ch, start, length)));
            pressure_sea = false;
        } if (visibility) {
            measurement.setVisibility(Float.parseFloat(new String(ch, start, length)));
            visibility = false;
        } if (wind) {
            measurement.setWind(Float.parseFloat(new String(ch, start, length)));
            wind = false;
        } if (rainfall) {
            measurement.setRainfall(Float.parseFloat(new String(ch, start, length)));
            rainfall = false;
        } if (snowfall) {
            measurement.setSnowfall(Float.parseFloat(new String(ch, start, length)));
            snowfall = false;
        } if (flags) {
            measurement.setFlags(new String(ch, start, length));
            flags = false;
        } if (cloud_cover) {
            measurement.setCloud_cover(Float.parseFloat(new String(ch, start, length)));
            cloud_cover = false;
        } if (wind_direction) {
            measurement.setWind_direction(Integer.parseInt(new String(ch, start, length)));
            wind_direction = false;
        }
    }
}
