<?php
declare(strict_types = 1);

namespace ws\loewe\polyphase_meter;

class PolyphaseMeterReading {

    /**
     * the raw data wrapped in this reading
     *
     * A reading might look like so (cf. page 9 in https://www.stadtwerke-burgdorf-netz.de/_Resources/Persistent/9450d40cdc3d62d8de38a3e4b06ad5d6805c87b4/Gebrauchsanleitung_LK13BE8030x9.pdf):
     * <code>
     *      /LOG5LK13BE803049
     *      1-0:96.1.0*255(001LOG0064800017)
     *      1-0:1.8.0*255(000000.4392*kWh)
     *      1-0:1.8.1*255(000000.0000*kWh)
     *      1-0:1.8.2*255(000000.4392*kWh)
     *      1-0:2.8.0*255(000000.8322*kWh)
     *      1-0:16.7.0*255(000000*W)
     *      1-0:32.7.0*255(000.0*V)
     *      1-0:52.7.0*255(000.0*V)
     *      1-0:72.7.0*255(229.9*V)
     *      1-0:31.7.0*255(000.00*A)
     *      1-0:51.7.0*255(000.00*A)
     *      1-0:71.7.0*255(000.03*A)
     *      1-0:81.7.1*255(000*deg)
     *      1-0:81.7.2*255(000*deg)
     *      1-0:81.7.4*255(000*deg)
     *      1-0:81.7.15*255(000*deg)
     *      1-0:81.7.26*255(000*deg)
     *      1-0:14.7.0*255(49.9*Hz)
     *      1-0:1.8.0*96(00000.0*kWh)
     *      1-0:1.8.0*97(00000.0*kWh)
     *      1-0:1.8.0*98(00000.0*kWh)
     *      1-0:1.8.0*99(00000.0*kWh)
     *      1-0:1.8.0*100(00000.4*kWh)
     *      1-0:0.2.0*255(ver.03,EF8C,20170504)
     *      1-0:96.90.2*255(0C69)
     *      1-0:97.97.0*255(00000000)
     *      /LOG5LK13BE803049
     * <code>
     *
     * @var string
     */
    private string $rawData;

    /**
     * This method creates an instance of this class holding a reading from the {@link PolyphaseMeterConnector}.
     *
     * @param string $rawData the raw data read from the {@link PolyphaseMeterConnector}
     */
    function __construct(string $rawData) {
        $this->rawData = $rawData;
    }

    /**
     * This method extracts from the reading the value for a given key.
     *
     * Examples of valid keys for Logarex LK13BE are:
     *  - '1-0:1.8.0*255'
     *  - '1-0:2.8.0*255'
     *  ...
     *
     * @param string $key the key for which to extract the data
     * @return array the (potentially) empty collection (as array of preg_match matches) of values for the given key
     */
    public function extract($key): array {
        $lines = explode(PHP_EOL, $this->rawData);

        $matches = array();
        foreach ($lines as $line) {
            if (preg_match('/'.preg_quote($key).'.*\((.*?)\*/', trim($line), $matches) === 1) {
                return $matches;
            }
        }

        return $matches;
    }

    /**
     * This method returns the raw data of this reading as string.
     *
     * @return string the raw data of this reading
     */
    public function __toString() {
        return $this->rawData;
    }
}
