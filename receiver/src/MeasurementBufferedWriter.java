import java.io.BufferedWriter;
import java.io.FileWriter;
import java.io.IOException;

/**
 * The MeasurementBufferedWriter class is a BufferedWriter that knows the location of the file
 * it is working on. This is necessary for the writing loop in MeasurementLogger
 *
 * @author Jan Hendrik Haanstra, Bessel Bode
 * @version 1.1
 * @since 2018-01-28
 */
public class MeasurementBufferedWriter extends BufferedWriter {
    private String location;

    /**
     * Constructor for the MeasurementBufferedWriter class.
     *
     * @param location Location of the file that the Bufferedwriter is working on
     * @throws IOException Covers the Bufferedwriter constructor
     */
    public MeasurementBufferedWriter(String location) throws IOException {
        super(new FileWriter(location, true));
        this.location = location;
    }

    public String getLocation() {
        return location;
    }
}
