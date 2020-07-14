<?php

function getReferenceNumber() {
	$lasku = rand(100000, 999999);  
	$refnumber = SuomalainenViite::luo($lasku);
	return $refnumber;
}

# Moduuli suomalaisten viitenumeroiden käsittelyyn.
class SuomalainenViite {
	# Luo kokonaisen viitteen (alku + tarkiste) alkuosan perusteella.
	public static function luo($alku, $ryhmittely = true) {
		# Poistetaan muut kuin numerot.
		$alku = preg_replace("/[^0-9]*/s", "", $alku);

		# Tarkastusmerkin laskenta.
		$summa = 0;
		$l = strlen($alku);
		for ($i = 0; $i < $l; ++$i) {
			$summa += substr($alku, -1 - $i, 1) * [7, 3, 1][$i % 3];
		}
		$merkki = (10 - $summa % 10) % 10;
		$viite = $alku . $merkki;

		return $ryhmittely ? self::ryhmittele($viite) : $viite;
	}

	# Ryhmittelee viitenumeron viiden numeron sarjoihin lopusta alkuun.
	public static function ryhmittele($viite) {
		$viite = preg_replace("/[^0-9]*/s", "", $viite);
		return strrev(trim(chunk_split(strrev($viite), 5, " ")));
	}

	# Tarkastaa, onko viite kelvollinen.
	public static function tarkasta($viite) {
		# Vääriä merkkejä?
		if (strspn($viite, "0123456789 ") != strlen($viite)) {
			return false;
		}
		$viite = str_replace(" ", "", $viite);
		# Väärä pituus?
		if (strlen($viite) > 20 || strlen($viite) < 4) {
			return false;
		}
		# Väärä tarkistusmerkki?
		return $viite == self::luo(substr($viite, 0, -1), false);
	}
}
?>