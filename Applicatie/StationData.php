<?php
    class StationData {
        private $station_id;
        private $country;
        private $region;
        private $maxhPa;

        public function __construct($station_id, $country, $region, $maxhPa)
        {
            $this->station_id = $station_id;
            $this->country = $country;
            $this->region = $region;
            $this->maxhPa = $maxhPa;
        }

        public function getStationId()
        {
            return $this->station_id;
        }

        public function getCountry()
        {
            return $this->country;
        }

        public function getRegion()
        {
            return $this->region;
        }

        public function getMaxhPa()
        {
            return $this->maxhPa;
        }

        public function setMaxhPa($maxhPa)
        {
            $this->maxhPa = $maxhPa;
        }
    }
?>