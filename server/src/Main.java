public class Main {

    public static void main(String[] args) {
        DataLog log = new DataLog();
        log.readLog();
        log.writeToLog("test123");
        log.readLog();
    }
}
