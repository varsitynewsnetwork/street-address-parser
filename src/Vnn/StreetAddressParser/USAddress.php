<?php

namespace Vnn\StreetAddressParser;

use Vnn\StreetAddressParser\StreetAddress;
/**
 * Class USAddress
 *
 * Recognized Address Formats
 *   1600 Pennsylvania Ave Washington DC 20006
 *   1600 Pennsylvania Ave #400, Washington, DC, 20006
 *   1600 Pennsylvania Ave Washington, DC
 *   1600 Pennsylvania Ave #400 Washington DC
 *   1600 Pennsylvania Ave, 20006
 *   1600 Pennsylvania Ave #400, 20006
 *   1600 Pennsylvania Ave 20006
 *   1600 Pennsylvania Ave #400 20006
 *
 * Recognized Intersection Formats
 *
 *   Hollywood & Vine, Los Angeles, CA
 *   Hollywood Blvd and Vine St, Los Angeles, CA
 *   Mission Street at Valencia Street, San Francisco, CA
 *   Hollywood & Vine, Los Angeles, CA, 90028
 *   Hollywood Blvd and Vine St, Los Angeles, CA, 90028
 *   Mission Street at Valencia Street, San Francisco, CA, 90028
 *
 * @package Vnn\StreetAddressParser
 */
class USAddress
{
    private $DIRECTIONAL = array(
        "north" => "N",
        "northeast" => "NE",
        "east" => "E",
        "southeast" => "SE",
        "south" => "S",
        "southwest" => "SW",
        "west" => "W",
        "northwest" => "NW"
    );

    private $DIRECTION_CODES = array();

    private $STREET_TYPES = array(
        "allee" => "aly",
        "alley" => "aly",
        "ally" => "aly",
        "anex" => "anx",
        "annex" => "anx",
        "annx" => "anx",
        "arcade" => "arc",
        "av" => "ave",
        "aven" => "ave",
        "avenu" => "ave",
        "avenue" => "ave",
        "avn" => "ave",
        "avnue" => "ave",
        "bayoo" => "byu",
        "bayou" => "byu",
        "beach" => "bch",
        "bend" => "bnd",
        "bluf" => "blf",
        "bluff" => "blf",
        "bluffs" => "blfs",
        "bot" => "btm",
        "bottm" => "btm",
        "bottom" => "btm",
        "boul" => "blvd",
        "boulevard" => "blvd",
        "boulv" => "blvd",
        "branch" => "br",
        "brdge" => "brg",
        "bridge" => "brg",
        "brnch" => "br",
        "brook" => "brk",
        "brooks" => "brks",
        "burg" => "bg",
        "burgs" => "bgs",
        "bypa" => "byp",
        "bypas" => "byp",
        "bypass" => "byp",
        "byps" => "byp",
        "camp" => "cp",
        "canyn" => "cyn",
        "canyon" => "cyn",
        "cape" => "cpe",
        "causeway" => "cswy",
        "causway" => "cswy",
        "cen" => "ctr",
        "cent" => "ctr",
        "center" => "ctr",
        "centers" => "ctrs",
        "centr" => "ctr",
        "centre" => "ctr",
        "circ" => "cir",
        "circl" => "cir",
        "circle" => "cir",
        "circles" => "cirs",
        "ck" => "crk",
        "cliff" => "clf",
        "cliffs" => "clfs",
        "club" => "clb",
        "cmp" => "cp",
        "cnter" => "ctr",
        "cntr" => "ctr",
        "cnyn" => "cyn",
        "common" => "cmn",
        "corner" => "cor",
        "corners" => "cors",
        "course" => "crse",
        "court" => "ct",
        "courts" => "cts",
        "cove" => "cv",
        "coves" => "cvs",
        "cr" => "crk",
        "crcl" => "cir",
        "crcle" => "cir",
        "crecent" => "cres",
        "creek" => "crk",
        "crescent" => "cres",
        "cresent" => "cres",
        "crest" => "crst",
        "crossing" => "xing",
        "crossroad" => "xrd",
        "crscnt" => "cres",
        "crsent" => "cres",
        "crsnt" => "cres",
        "crssing" => "xing",
        "crssng" => "xing",
        "crt" => "ct",
        "curve" => "curv",
        "cur" => "curv",
        "dale" => "dl",
        "dam" => "dm",
        "div" => "dv",
        "divide" => "dv",
        "driv" => "dr",
        "drive" => "dr",
        "drives" => "drs",
        "drv" => "dr",
        "dvd" => "dv",
        "estate" => "est",
        "estates" => "ests",
        "exp" => "expy",
        "expr" => "expy",
        "express" => "expy",
        "expressway" => "expy",
        "expw" => "expy",
        "extension" => "ext",
        "extensions" => "exts",
        "extn" => "ext",
        "extnsn" => "ext",
        "falls" => "fls",
        "ferry" => "fry",
        "field" => "fld",
        "fields" => "flds",
        "flat" => "flt",
        "flats" => "flts",
        "ford" => "frd",
        "fords" => "frds",
        "forest" => "frst",
        "forests" => "frst",
        "forg" => "frg",
        "forge" => "frg",
        "forges" => "frgs",
        "fork" => "frk",
        "forks" => "frks",
        "fort" => "ft",
        "freeway" => "fwy",
        "freewy" => "fwy",
        "frry" => "fry",
        "frt" => "ft",
        "frway" => "fwy",
        "frwy" => "fwy",
        "garden" => "gdn",
        "gardens" => "gdns",
        "gardn" => "gdn",
        "gateway" => "gtwy",
        "gatewy" => "gtwy",
        "gatway" => "gtwy",
        "glen" => "gln",
        "glens" => "glns",
        "grden" => "gdn",
        "grdn" => "gdn",
        "grdns" => "gdns",
        "green" => "grn",
        "greens" => "grns",
        "grov" => "grv",
        "grove" => "grv",
        "groves" => "grvs",
        "gtway" => "gtwy",
        "harb" => "hbr",
        "harbor" => "hbr",
        "harbors" => "hbrs",
        "harbr" => "hbr",
        "haven" => "hvn",
        "havn" => "hvn",
        "height" => "hts",
        "heights" => "hts",
        "hgts" => "hts",
        "highway" => "hwy",
        "highwy" => "hwy",
        "hill" => "hl",
        "hills" => "hls",
        "hiway" => "hwy",
        "hiwy" => "hwy",
        "hllw" => "holw",
        "hollow" => "holw",
        "hollows" => "holw",
        "holws" => "holw",
        "hrbor" => "hbr",
        "ht" => "hts",
        "hway" => "hwy",
        "inlet" => "inlt",
        "island" => "is",
        "islands" => "iss",
        "isles" => "isle",
        "islnd" => "is",
        "islnds" => "iss",
        "jction" => "jct",
        "jctn" => "jct",
        "jctns" => "jcts",
        "junction" => "jct",
        "junctions" => "jcts",
        "junctn" => "jct",
        "juncton" => "jct",
        "key" => "ky",
        "keys" => "kys",
        "knol" => "knl",
        "knoll" => "knl",
        "knolls" => "knls",
        "la" => "ln",
        "lake" => "lk",
        "lakes" => "lks",
        "landing" => "lndg",
        "lane" => "ln",
        "lanes" => "ln",
        "ldge" => "ldg",
        "light" => "lgt",
        "lights" => "lgts",
        "lndng" => "lndg",
        "loaf" => "lf",
        "lock" => "lck",
        "locks" => "lcks",
        "lodg" => "ldg",
        "lodge" => "ldg",
        "loops" => "loop",
        "manor" => "mnr",
        "manors" => "mnrs",
        "meadow" => "mdw",
        "meadows" => "mdws",
        "medows" => "mdws",
        "mill" => "ml",
        "mills" => "mls",
        "mission" => "msn",
        "missn" => "msn",
        "mnt" => "mt",
        "mntain" => "mtn",
        "mntn" => "mtn",
        "mntns" => "mtns",
        "motorway" => "mtwy",
        "mount" => "mt",
        "mountain" => "mtn",
        "mountains" => "mtns",
        "mountin" => "mtn",
        "mssn" => "msn",
        "mtin" => "mtn",
        "neck" => "nck",
        "orchard" => "orch",
        "orchrd" => "orch",
        "overpass" => "opas",
        "ovl" => "oval",
        "parks" => "park",
        "parkway" => "pkwy",
        "parkways" => "pkwy",
        "parkwy" => "pkwy",
        "passage" => "psge",
        "paths" => "path",
        "pikes" => "pike",
        "pine" => "pne",
        "pines" => "pnes",
        "pk" => "park",
        "pkway" => "pkwy",
        "pkwys" => "pkwy",
        "pky" => "pkwy",
        "place" => "pl",
        "plain" => "pln",
        "plaines" => "plns",
        "plains" => "plns",
        "plaza" => "plz",
        "plza" => "plz",
        "point" => "pt",
        "points" => "pts",
        "port" => "prt",
        "ports" => "prts",
        "prairie" => "pr",
        "prarie" => "pr",
        "prk" => "park",
        "prr" => "pr",
        "rad" => "radl",
        "radial" => "radl",
        "radiel" => "radl",
        "ranch" => "rnch",
        "ranches" => "rnch",
        "rapid" => "rpd",
        "rapids" => "rpds",
        "rdge" => "rdg",
        "rest" => "rst",
        "ridge" => "rdg",
        "ridges" => "rdgs",
        "river" => "riv",
        "rivr" => "riv",
        "rnchs" => "rnch",
        "road" => "rd",
        "roads" => "rds",
        "route" => "rte",
        "rvr" => "riv",
        "shoal" => "shl",
        "shoals" => "shls",
        "shoar" => "shr",
        "shoars" => "shrs",
        "shore" => "shr",
        "shores" => "shrs",
        "skyway" => "skwy",
        "spng" => "spg",
        "spngs" => "spgs",
        "spring" => "spg",
        "springs" => "spgs",
        "sprng" => "spg",
        "sprngs" => "spgs",
        "spurs" => "spur",
        "sqr" => "sq",
        "sqre" => "sq",
        "sqrs" => "sqs",
        "squ" => "sq",
        "square" => "sq",
        "squares" => "sqs",
        "station" => "sta",
        "statn" => "sta",
        "stn" => "sta",
        "str" => "st",
        "strav" => "stra",
        "strave" => "stra",
        "straven" => "stra",
        "stravenue" => "stra",
        "stravn" => "stra",
        "stream" => "strm",
        "street" => "st",
        "streets" => "sts",
        "streme" => "strm",
        "strt" => "st",
        "strvn" => "stra",
        "strvnue" => "stra",
        "sumit" => "smt",
        "sumitt" => "smt",
        "summit" => "smt",
        "terr" => "ter",
        "terrace" => "ter",
        "throughway" => "trwy",
        "tpk" => "tpke",
        "tr" => "trl",
        "trace" => "trce",
        "traces" => "trce",
        "track" => "trak",
        "tracks" => "trak",
        "trafficway" => "trfy",
        "trail" => "trl",
        "trails" => "trl",
        "trk" => "trak",
        "trks" => "trak",
        "trls" => "trl",
        "trnpk" => "tpke",
        "trpk" => "tpke",
        "tunel" => "tunl",
        "tunls" => "tunl",
        "tunnel" => "tunl",
        "tunnels" => "tunl",
        "tunnl" => "tunl",
        "turnpike" => "tpke",
        "turnpk" => "tpke",
        "underpass" => "upas",
        "union" => "un",
        "unions" => "uns",
        "valley" => "vly",
        "valleys" => "vlys",
        "vally" => "vly",
        "vdct" => "via",
        "viadct" => "via",
        "viaduct" => "via",
        "view" => "vw",
        "views" => "vws",
        "vill" => "vlg",
        "villag" => "vlg",
        "village" => "vlg",
        "villages" => "vlgs",
        "ville" => "vl",
        "villg" => "vlg",
        "villiage" => "vlg",
        "vist" => "vis",
        "vista" => "vis",
        "vlly" => "vly",
        "vst" => "vis",
        "vsta" => "vis",
        "walks" => "walk",
        "well" => "wl",
        "wells" => "wls",
        "wy" => "way"
    );

    private $STREET_TYPES_LIST = array();

    private $STATE_CODES = array(
        "alabama" => "AL",
        "alaska" => "AK",
        "american samoa" => "AS",
        "arizona" => "AZ",
        "arkansas" => "AR",
        "california" => "CA",
        "colorado" => "CO",
        "connecticut" => "CT",
        "delaware" => "DE",
        "district of columbia" => "DC",
        "federated states of micronesia" => "FM",
        "florida" => "FL",
        "georgia" => "GA",
        "guam" => "GU",
        "hawaii" => "HI",
        "idaho" => "ID",
        "illinois" => "IL",
        "indiana" => "IN",
        "iowa" => "IA",
        "kansas" => "KS",
        "kentucky" => "KY",
        "louisiana" => "LA",
        "maine" => "ME",
        "marshall islands" => "MH",
        "maryland" => "MD",
        "massachusetts" => "MA",
        "michigan" => "MI",
        "minnesota" => "MN",
        "mississippi" => "MS",
        "missouri" => "MO",
        "montana" => "MT",
        "nebraska" => "NE",
        "nevada" => "NV",
        "new hampshire" => "NH",
        "new jersey" => "NJ",
        "new mexico" => "NM",
        "new york" => "NY",
        "north carolina" => "NC",
        "north dakota" => "ND",
        "northern mariana islands" => "MP",
        "ohio" => "OH",
        "oklahoma" => "OK",
        "oregon" => "OR",
        "palau" => "PW",
        "pennsylvania" => "PA",
        "puerto rico" => "PR",
        "rhode island" => "RI",
        "south carolina" => "SC",
        "south dakota" => "SD",
        "tennessee" => "TN",
        "texas" => "TX",
        "utah" => "UT",
        "vermont" => "VT",
        "virgin islands" => "VI",
        "virginia" => "VA",
        "washington" => "WA",
        "west virginia" => "WV",
        "wisconsin" => "WI",
        "wyoming" => "WY"
    );

    private $STATE_NAMES = array();

    private $STATE_FIPS = array(
        "01" => "AL",
        "02" => "AK",
        "04" => "AZ",
        "05" => "AR",
        "06" => "CA",
        "08" => "CO",
        "09" => "CT",
        "10" => "DE",
        "11" => "DC",
        "12" => "FL",
        "13" => "GA",
        "15" => "HI",
        "16" => "ID",
        "17" => "IL",
        "18" => "IN",
        "19" => "IA",
        "20" => "KS",
        "21" => "KY",
        "22" => "LA",
        "23" => "ME",
        "24" => "MD",
        "25" => "MA",
        "26" => "MI",
        "27" => "MN",
        "28" => "MS",
        "29" => "MO",
        "30" => "MT",
        "31" => "NE",
        "32" => "NV",
        "33" => "NH",
        "34" => "NJ",
        "35" => "NM",
        "36" => "NY",
        "37" => "NC",
        "38" => "ND",
        "39" => "OH",
        "40" => "OK",
        "41" => "OR",
        "42" => "PA",
        "44" => "RI",
        "45" => "SC",
        "46" => "SD",
        "47" => "TN",
        "48" => "TX",
        "49" => "UT",
        "50" => "VT",
        "51" => "VA",
        "53" => "WA",
        "54" => "WV",
        "55" => "WI",
        "56" => "WY",
        "72" => "PR",
        "78" => "VI"
    );

    private $FIPS_STATES = array();

    public function __construct()
    {
        $this->DIRECTION_CODES = array_flip($this->DIRECTIONAL);
        foreach ($this->STREET_TYPES as $key => $value) {
            $this->STREET_TYPES_LIST[$key] = true;
            $this->STREET_TYPES_LIST[$value] = true;
        }
        $this->STATE_NAMES = array_flip($this->STATE_CODES);
        $this->FIPS_STATES = array_flip($this->STATE_FIPS);
    }

    /**
     * Parse an arbitrary string (formatted as an address or intersection) and returns an instance of
     * Vnn\StreetAddressParser\StreetAddress or NULL if the location cannot be parsed.
     *
     * @param  string        $location Address or intersection string
     * @param  boolean       $informal True make parsing more lenient
     * @return StreetAddress
     */
    public function parse($location, $informal = false)
    {
        // 1 == match, 0 == no match, FALSE == error:
        if (preg_match("/" . $this->corner_regexp() . "/i", $location) == 1) {
            return $this->parse_intersection($location);
        } elseif ($informal) {
            return $this->parse_informal_address($location);
        } else {
            return $this->parse_address($location);
        }
    }

    /**
     * Parses a location known to be an intersection, and returns an instance of
     * StreetAddress or NULL if the intersection cannot be parsed.
     *
     * Example: Hollywood & Vine, Los Angeles, CA
     *
     * @param string $inter
     * @return \Vnn\StreetAddressParser\StreetAddress $address
     */
    protected function parse_intersection($inter)
    {
        $regex = '\A\W*' . $this->street_regexp() . '\W*?
          \s+' . $this->corner_regexp() . '\s+' .
          $this->street_regexp() . '\W+' .
          $this->place_regexp() . '\W*\Z';

        $matches = array();
        if (preg_match("/" . $regex . "/ixu", $inter, $matches) !== 1)
            return NULL;

        $addr = new StreetAddress();
        $addr->street = (isset($matches[4]) && strlen($matches[4]) > 0) ? $matches[4] : $matches[9];
        $addr->street_type = $matches[5];
        $addr->suffix = $matches[6];
        $addr->prefix = $matches[3];
        $addr->street2 = (isset($matches[15]) && strlen($matches[15]) > 0) ? $matches[15] : $matches[20];
        $addr->street_type2 = $matches[16];
        $addr->suffix2 = $matches[17];
        $addr->prefix2 = $matches[14];
        $addr->city = $matches[23];
        $addr->state = isset($matches[24]) ? $matches[24] : "";
        $addr->postal_code = isset($matches[25]) ? $matches[25] : "";

        $this->normalize_address($addr);

        return $addr;
    }

    protected function parse_address($addr)
    {
        $matches = array();

        if (preg_match("/" . $this->address_regexp() . "/ixu", $addr, $matches) !== 1)
            return NULL;

        $addr = new StreetAddress();

        $addr->number = $matches[1];

        if (isset($matches[5]) && strlen($matches[5]) > 0)
            $addr->street = $matches[5];
        elseif (isset($matches[10]) && strlen($matches[10]) > 0)
            $addr->street = $matches[10];
        elseif (isset($matches[2]) && strlen($matches[2]) > 0)
            $addr->street = $matches[2];

        $addr->street_type = (isset($matches[6]) && strlen($matches[6]) > 0) ? $matches[6] : $matches[3];
        $addr->unit = isset($matches[14]) ? $matches[14] : "";
        $addr->unit_prefix = isset($matches[13]) ? $matches[13] : "";
        $addr->suffix = (isset($matches[7]) && strlen($matches[7]) > 0) ? $matches[7] : $matches[12];
        $addr->prefix = $matches[4];
        $addr->city = isset($matches[15]) ? $matches[15] : "";
        $addr->state = isset($matches[16]) ? $matches[16] : "";
        $addr->postal_code = isset($matches[17]) ? $matches[17] : "";
        $addr->postal_code_ext = isset($matches[18]) ? $matches[18] : "";

        $this->normalize_address($addr);

        return $addr;
    }

    protected function parse_informal_address($addr)
    {
        $matches = array();
        if (preg_match("/" . $this->informal_address_regexp() . "/ixu", $addr, $matches) !== 1)
            return NULL;

        $addr = new StreetAddress();

        $addr->number = $matches[1];

        if (isset($matches[5]) && strlen($matches[5]) > 0)
            $addr->street = $matches[5];
        elseif (isset($matches[10]) && strlen($matches[10]) > 0)
            $addr->street = $matches[10];
        elseif (isset($matches[2]) && strlen($matches[2]) > 0)
            $addr->street = $matches[2];

        $addr->street_type = (isset($matches[6]) && strlen($matches[6]) > 0) ? $matches[6] : $matches[3];
        $addr->unit = isset($matches[14]) ? $matches[14] : "";
        $addr->unit_prefix = isset($matches[13]) ? $matches[13] : "";
        $addr->suffix = (isset($matches[7]) && strlen($matches[7]) > 0) ? $matches[7] : isset($matches[12]) ? $matches[12] : "";
        $addr->prefix = $matches[4];
        $addr->city = isset($matches[15]) ? $matches[15] : "";
        $addr->state = isset($matches[16]) ? $matches[16] : "";
        $addr->postal_code = isset($matches[17]) ? $matches[17] : "";
        $addr->postal_code_ext = isset($matches[18]) ? $matches[18] : "";

        $this->normalize_address($addr);

        return $addr;
    }

    protected function street_type_regexp()
    {
        return implode("|", array_keys($this->STREET_TYPES_LIST));
    }

    protected function number_regexp()
    {
        return '\d+-?\d*';
    }

    protected function fraction_regexp()
    {
        return '\d+\/\d+';
    }

    protected function state_regexp()
    {
        return str_replace(
            " ",
            "\\s",
            implode(
                "|",
                array_merge(
                    array_keys($this->STATE_CODES),
                    array_keys($this->STATE_NAMES)
                )
            )
        );
    }

    protected function city_and_state_regexp()
    {
        return '(?:
            ([^\d,]+?)\W+
            (' . $this->state_regexp() . ')
            )';
    }

    protected function direct_regexp()
    {
        $first_part = implode("|", array_keys($this->DIRECTIONAL)) . "|";

        $directional_values = array_values($this->DIRECTIONAL);
        usort($directional_values, function ($a, $b) {
            return strlen($b) - strlen($a);
        });

        // append "." after all letters to handle abbreviations
        $handle_abbr = array();
        $callback = function ($val) use (&$handle_abbr) {
            $f = preg_replace("/(\w)/", "$1.", $val);
            $handle_abbr[] = preg_quote($f);
            $handle_abbr[] = preg_quote($val);
        };

        array_walk($directional_values, $callback);

        return $first_part . implode("|", $handle_abbr);
    }

    protected function zip_regexp()
    {
        return '(\d{5})(?:-?(\d{4})?)';
    }

    protected function corner_regexp()
    {
        return '(?:\band\b|\bat\b|&|\@)';
    }

    protected function unit_regexp()
    {
        return '(?:(su?i?te|p\W*[om]\W*b(?:ox)?|dept|apt|apartment|ro*m|fl|unit|box)\W+|\#\W*)([\w-]+)';
    }

    protected function street_regexp()
    {
        return '(?:
                  (?:(' . $this->direct_regexp() . ')\W+
                  (' . $this->street_type_regexp() . ')\b)
                  |
                  (?:(' . $this->direct_regexp() . ')\W+)?
                  (?:
                    ([^,]+)
                    (?:[^\w,]+(' . $this->street_type_regexp() . ')\b)
                    (?:[^\w,]+(' . $this->direct_regexp() . ')\b)?
                   |
                    ([^,]*\d)
                    (' . $this->direct_regexp() . ')\b
                   |
                    ([^,]+?)
                    (?:[^\w,]+(' . $this->street_type_regexp() . ')\b)?
                    (?:[^\w,]+(' . $this->direct_regexp() . ')\b)?
                  )
                )';
    }

    protected function place_regexp()
    {
        return '(?:' . $this->city_and_state_regexp() . '\W*)?
                (?:' . $this->zip_regexp() . ')?';

    }

    protected function address_regexp()
    {
        return '\A\W*
                (' . $this->number_regexp() . ')\W*
                (?:' . $this->fraction_regexp() . '\W*)?' .
                $this->street_regexp() . '\W+
                (?:' . $this->unit_regexp() . '\W+)?' .
                $this->place_regexp() .
              '\W*\Z';
    }

    protected function informal_address_regexp()
    {
        return '\A\s*
                (' . $this->number_regexp() . ')\W*
                (?:' . $this->fraction_regexp() . '\W*)?' .
                $this->street_regexp() . '(?:\W+|\Z)
                (?:' . $this->unit_regexp() . '(?:\W+|\Z))?' .
                '(?:' . $this->place_regexp() . ')?';
    }

    private function normalize_address(StreetAddress $addr)
    {
        if ($addr->state) $addr->state = $this->normalize_state($addr->state);
        if ($addr->street_type) $addr->street_type = $this->normalize_street_type($addr->street_type);
        if ($addr->prefix) $addr->prefix = $this->normalize_directional($addr->prefix);
        if ($addr->suffix) $addr->suffix = $this->normalize_directional($addr->suffix);
        if ($addr->street) $addr->street = preg_replace_callback("/\b([a-z])/", function ($val) { if(is_array($val)) return ucwords($val[0]); else return ucwords($val); }, $addr->street);
        if ($addr->street_type2) $addr->street_type2 = $this->normalize_street_type($addr->street_type2);
        if ($addr->prefix2) $addr->prefix2 = $this->normalize_directional($addr->prefix2);
        if ($addr->suffix2) $addr->suffix2 = $this->normalize_directional($addr->suffix2);
        if ($addr->street2) $addr->street2 = preg_replace_callback("/\b([a-z])/", function ($val) { if(is_array($val)) return ucwords($val[0]); else return ucwords($val); }, $addr->street2);
        if ($addr->city) $addr->city = preg_replace_callback("/\b([a-z])/", function ($val) { if(is_array($val)) return ucwords($val[0]); else return ucwords($val); }, $addr->city);
        if ($addr->unit_prefix) $addr->unit_prefix = ucwords($addr->unit_prefix);
    }

    private function normalize_state($state)
    {
        if (strlen($state) < 3) {
            return strtoupper($state);
        } else {
            return $this->STATE_CODES[strtolower($state)];
        }
    }

    private function normalize_street_type($street_type)
    {
        $street_type = strtolower($street_type);
        if (isset($this->STREET_TYPES_LIST[$street_type])) {
            if (isset($this->STREET_TYPES[$street_type]))
                $street_type = $this->STREET_TYPES[$street_type];
        }
        return ucfirst($street_type);
    }

    private function normalize_directional($dir)
    {
        if (strlen($dir) < 3)
            return strtoupper($dir);
        else
            return $this->DIRECTIONAL[strtolower($dir)];
    }

}
