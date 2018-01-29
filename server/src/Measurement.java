import java.time.LocalDateTime;

public class Measurement {
    private LocalDateTime datetime;
    private int station;
    private float temperature;
    private float dewpoint;
    private float pressure_station;
    private float pressure_sea;
    private float visibility;
    private float wind;
    private float rainfall;
    private float snowfall;
    private String flags;
    private char frozen;
    private char rain;
    private char snow;
    private char hail;
    private char storm;
    private char whirlwind;
    private float cloud_cover;
    private int wind_direction;

    public Measurement(LocalDateTime datetime, int station, float temperature, float dewpoint, float pressure_station, float pressure_sea, float visibility, float wind, float rainfall, float snowfall, String flags, float cloud_cover, int wind_direction) {
        this.datetime = datetime;
        this.station = station;
        this.temperature = temperature;
        this.dewpoint = dewpoint;
        this.pressure_station = pressure_station;
        this.pressure_sea = pressure_sea;
        this.visibility = visibility;
        this.wind = wind;
        this.flags  = flags;
        this.rainfall = rainfall;
        this.snowfall = snowfall;
        this.frozen = flags.charAt(0);
        this.rain = flags.charAt(1);
        this.snow = flags.charAt(2);
        this.hail = flags.charAt(3);
        this.storm = flags.charAt(4);
        this.whirlwind = flags.charAt(5);
        this.cloud_cover = cloud_cover;
        this.wind_direction = wind_direction;
    }

    public LocalDateTime getDatetime() {
        return datetime;
    }

    public int getStation() {
        return station;
    }

    public float getTemperature() {
        return temperature;
    }

    public float getDewpoint() {
        return dewpoint;
    }

    public float getPressure_station() {
        return pressure_station;
    }

    public float getPressure_sea() {
        return pressure_sea;
    }

    public float getVisibility() {
        return visibility;
    }

    public float getWind() {
        return wind;
    }

    public float getRainfall() {
        return rainfall;
    }

    public float getSnowfall() {
        return snowfall;
    }

    public String getFlags() {
        return flags;
    }

    public char getFrozen() {
        return frozen;
    }

    public char getRain() {
        return rain;
    }

    public char getSnow() {
        return snow;
    }

    public char getHail() {
        return hail;
    }

    public char getStorm() {
        return storm;
    }

    public char getWhirlwind() {
        return whirlwind;
    }

    public float getCloud_cover() {
        return cloud_cover;
    }

    public int getWind_direction() {
        return wind_direction;
    }
}
