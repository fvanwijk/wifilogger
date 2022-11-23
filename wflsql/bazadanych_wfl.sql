-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Aug 27, 2020 at 12:00 AM
-- Server version: 10.0.38-MariaDB-0+deb8u1
-- PHP Version: 7.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `serwer22982_wfl`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `user_login` varchar(255) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `user_status` tinyint(1) NOT NULL DEFAULT '0',
  `user_registered` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `hilowex`
--

CREATE TABLE `hilowex` (
  `hlex_id` bigint(20) NOT NULL,
  `wid` bigint(20) UNSIGNED NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `time_utc` int(10) UNSIGNED NOT NULL,
  `time_loc` time NOT NULL,
  `date_loc` date NOT NULL,
  `xt0_tl` time DEFAULT NULL,
  `xt0_l` decimal(4,1) DEFAULT NULL,
  `xt0_th` time DEFAULT NULL,
  `xt0_h` decimal(4,1) DEFAULT NULL,
  `xt1_tl` time DEFAULT NULL,
  `xt1_l` decimal(4,1) DEFAULT NULL,
  `xt1_th` time DEFAULT NULL,
  `xt1_h` decimal(4,1) DEFAULT NULL,
  `xt2_tl` time DEFAULT NULL,
  `xt2_l` decimal(4,1) DEFAULT NULL,
  `xt2_th` time DEFAULT NULL,
  `xt2_h` decimal(4,1) DEFAULT NULL,
  `xt3_tl` time DEFAULT NULL,
  `xt3_l` decimal(4,1) DEFAULT NULL,
  `xt3_th` time DEFAULT NULL,
  `xt3_h` decimal(4,1) DEFAULT NULL,
  `xt4_tl` time DEFAULT NULL,
  `xt4_l` decimal(4,1) DEFAULT NULL,
  `xt4_th` time DEFAULT NULL,
  `xt4_h` decimal(4,1) DEFAULT NULL,
  `xt5_tl` time DEFAULT NULL,
  `xt5_l` decimal(4,1) DEFAULT NULL,
  `xt5_th` time DEFAULT NULL,
  `xt5_h` decimal(4,1) DEFAULT NULL,
  `xt6_tl` time DEFAULT NULL,
  `xt6_l` decimal(4,1) DEFAULT NULL,
  `xt6_th` time DEFAULT NULL,
  `xt6_h` decimal(4,1) DEFAULT NULL,
  `xh0_tl` time DEFAULT NULL,
  `xh0_l` tinyint(3) UNSIGNED DEFAULT NULL,
  `xh0_th` time DEFAULT NULL,
  `xh0_h` tinyint(3) UNSIGNED DEFAULT NULL,
  `xh1_tl` time DEFAULT NULL,
  `xh1_l` tinyint(3) UNSIGNED DEFAULT NULL,
  `xh1_th` time DEFAULT NULL,
  `xh1_h` tinyint(3) UNSIGNED DEFAULT NULL,
  `xh2_tl` time DEFAULT NULL,
  `xh2_l` tinyint(3) UNSIGNED DEFAULT NULL,
  `xh2_th` time DEFAULT NULL,
  `xh2_h` tinyint(3) UNSIGNED DEFAULT NULL,
  `xh3_tl` time DEFAULT NULL,
  `xh3_l` tinyint(3) UNSIGNED DEFAULT NULL,
  `xh3_th` time DEFAULT NULL,
  `xh3_h` tinyint(3) UNSIGNED DEFAULT NULL,
  `xh4_tl` time DEFAULT NULL,
  `xh4_l` tinyint(3) UNSIGNED DEFAULT NULL,
  `xh4_th` time DEFAULT NULL,
  `xh4_h` tinyint(3) UNSIGNED DEFAULT NULL,
  `xh5_tl` time DEFAULT NULL,
  `xh5_l` tinyint(3) UNSIGNED DEFAULT NULL,
  `xh5_th` time DEFAULT NULL,
  `xh5_h` tinyint(3) UNSIGNED DEFAULT NULL,
  `xh6_tl` time DEFAULT NULL,
  `xh6_l` tinyint(3) UNSIGNED DEFAULT NULL,
  `xh6_th` time DEFAULT NULL,
  `xh6_h` tinyint(3) UNSIGNED DEFAULT NULL,
  `xst0_tl` time DEFAULT NULL,
  `xst0_l` decimal(4,1) DEFAULT NULL,
  `xst0_th` time DEFAULT NULL,
  `xst0_h` decimal(4,1) DEFAULT NULL,
  `xst1_tl` time DEFAULT NULL,
  `xst1_l` decimal(4,1) DEFAULT NULL,
  `xst1_th` time DEFAULT NULL,
  `xst1_h` decimal(4,1) DEFAULT NULL,
  `xst2_tl` time DEFAULT NULL,
  `xst2_l` decimal(4,1) DEFAULT NULL,
  `xst2_th` time DEFAULT NULL,
  `xst2_h` decimal(4,1) DEFAULT NULL,
  `xst3_tl` time DEFAULT NULL,
  `xst3_l` decimal(4,1) DEFAULT NULL,
  `xst3_th` time DEFAULT NULL,
  `xst3_h` decimal(4,1) DEFAULT NULL,
  `xlt0_tl` time DEFAULT NULL,
  `xlt0_l` decimal(4,1) DEFAULT NULL,
  `xlt0_th` time DEFAULT NULL,
  `xlt0_h` decimal(4,1) DEFAULT NULL,
  `xlt1_tl` time DEFAULT NULL,
  `xlt1_l` decimal(4,1) DEFAULT NULL,
  `xlt1_th` time DEFAULT NULL,
  `xlt1_h` decimal(4,1) DEFAULT NULL,
  `xlt2_tl` time DEFAULT NULL,
  `xlt2_l` decimal(4,1) DEFAULT NULL,
  `xlt2_th` time DEFAULT NULL,
  `xlt2_h` decimal(4,1) DEFAULT NULL,
  `xlt3_tl` time DEFAULT NULL,
  `xlt3_l` decimal(4,1) DEFAULT NULL,
  `xlt3_th` time DEFAULT NULL,
  `xlt3_h` decimal(4,1) DEFAULT NULL,
  `xsm0_tl` time DEFAULT NULL,
  `xsm0_l` tinyint(3) UNSIGNED DEFAULT NULL,
  `xsm0_th` time DEFAULT NULL,
  `xsm0_h` tinyint(3) UNSIGNED DEFAULT NULL,
  `xsm1_tl` time DEFAULT NULL,
  `xsm1_l` tinyint(3) UNSIGNED DEFAULT NULL,
  `xsm1_th` time DEFAULT NULL,
  `xsm1_h` tinyint(3) UNSIGNED DEFAULT NULL,
  `xsm2_tl` time DEFAULT NULL,
  `xsm2_l` tinyint(3) UNSIGNED DEFAULT NULL,
  `xsm2_th` time DEFAULT NULL,
  `xsm2_h` tinyint(3) UNSIGNED DEFAULT NULL,
  `xsm3_tl` time DEFAULT NULL,
  `xsm3_l` tinyint(3) UNSIGNED DEFAULT NULL,
  `xsm3_th` time DEFAULT NULL,
  `xsm3_h` tinyint(3) UNSIGNED DEFAULT NULL,
  `xlw0_tl` time DEFAULT NULL,
  `xlw0_l` tinyint(3) UNSIGNED DEFAULT NULL,
  `xlw0_th` time DEFAULT NULL,
  `xlw0_h` tinyint(3) UNSIGNED DEFAULT NULL,
  `xlw1_tl` time DEFAULT NULL,
  `xlw1_l` tinyint(3) UNSIGNED DEFAULT NULL,
  `xlw1_th` time DEFAULT NULL,
  `xlw1_h` tinyint(3) UNSIGNED DEFAULT NULL,
  `xlw2_tl` time DEFAULT NULL,
  `xlw2_l` tinyint(3) UNSIGNED DEFAULT NULL,
  `xlw2_th` time DEFAULT NULL,
  `xlw2_h` tinyint(3) UNSIGNED DEFAULT NULL,
  `xlw3_tl` time DEFAULT NULL,
  `xlw3_l` tinyint(3) UNSIGNED DEFAULT NULL,
  `xlw3_th` time DEFAULT NULL,
  `xlw3_h` tinyint(3) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `hilows`
--

CREATE TABLE `hilows` (
  `hl_id` bigint(20) NOT NULL,
  `wid` bigint(20) UNSIGNED NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `time_utc` int(10) UNSIGNED NOT NULL,
  `time_loc` time NOT NULL,
  `date_loc` date NOT NULL,
  `bar_tl` time DEFAULT NULL,
  `bar_l` decimal(5,3) DEFAULT NULL,
  `bar_th` time DEFAULT NULL,
  `bar_h` decimal(5,3) DEFAULT NULL,
  `wind_th` time DEFAULT NULL,
  `wind_h` decimal(4,1) DEFAULT NULL,
  `tempin_tl` time DEFAULT NULL,
  `tempin_l` decimal(4,1) DEFAULT NULL,
  `tempin_th` time DEFAULT NULL,
  `tempin_h` decimal(4,1) DEFAULT NULL,
  `humin_tl` time DEFAULT NULL,
  `humin_l` tinyint(3) UNSIGNED DEFAULT NULL,
  `humin_th` time DEFAULT NULL,
  `humin_h` tinyint(3) UNSIGNED DEFAULT NULL,
  `tempout_tl` time DEFAULT NULL,
  `tempout_l` decimal(4,1) DEFAULT NULL,
  `tempout_th` time DEFAULT NULL,
  `tempout_h` decimal(4,1) DEFAULT NULL,
  `humout_tl` time DEFAULT NULL,
  `humout_l` tinyint(3) UNSIGNED DEFAULT NULL,
  `humout_th` time DEFAULT NULL,
  `humout_h` tinyint(3) UNSIGNED DEFAULT NULL,
  `dew_tl` time DEFAULT NULL,
  `dew_l` decimal(4,1) DEFAULT NULL,
  `dew_th` time DEFAULT NULL,
  `dew_h` decimal(4,1) DEFAULT NULL,
  `chill_tl` time DEFAULT NULL,
  `chill_l` decimal(4,1) DEFAULT NULL,
  `heat_th` time DEFAULT NULL,
  `heat_h` decimal(4,1) DEFAULT NULL,
  `thsw_th` time DEFAULT NULL,
  `thsw_h` decimal(4,1) DEFAULT NULL,
  `solar_th` time DEFAULT NULL,
  `solar_h` decimal(5,1) DEFAULT NULL,
  `uv_th` time DEFAULT NULL,
  `uv_h` tinyint(3) UNSIGNED DEFAULT NULL,
  `rainr_th` time DEFAULT NULL,
  `rainr_h` decimal(10,5) DEFAULT NULL,
  `rain_day` decimal(10,5) DEFAULT NULL,
  `rain_mon` decimal(10,5) DEFAULT NULL,
  `rain_year` decimal(10,5) DEFAULT NULL,
  `et_day` decimal(10,5) DEFAULT NULL,
  `et_mon` decimal(10,5) DEFAULT NULL,
  `et_year` decimal(10,5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `logger`
--

CREATE TABLE `logger` (
  `log_id` bigint(20) UNSIGNED NOT NULL,
  `wid` bigint(20) UNSIGNED NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `davis_timestamp` int(10) UNSIGNED NOT NULL,
  `time` time NOT NULL,
  `date` date NOT NULL,
  `time_utc` int(10) UNSIGNED NOT NULL,
  `temp_out` decimal(4,1) DEFAULT NULL,
  `temp_high_out` decimal(4,1) DEFAULT NULL,
  `temp_low_out` decimal(4,1) DEFAULT NULL,
  `temp_in` decimal(4,1) DEFAULT NULL,
  `hum_out` tinyint(4) UNSIGNED DEFAULT NULL,
  `hum_in` tinyint(4) UNSIGNED DEFAULT NULL,
  `barometer` decimal(5,3) DEFAULT NULL,
  `rainfall` decimal(10,5) DEFAULT NULL,
  `rain_high_rate` decimal(10,5) DEFAULT NULL,
  `wind_avg` decimal(5,2) DEFAULT NULL,
  `wind_dir_avg` tinyint(4) UNSIGNED DEFAULT NULL,
  `wind_high` decimal(5,2) DEFAULT NULL,
  `wind_dir_high` tinyint(4) UNSIGNED DEFAULT NULL,
  `uv_avg` tinyint(4) UNSIGNED DEFAULT NULL,
  `uv_high` tinyint(4) UNSIGNED DEFAULT NULL,
  `et` tinyint(6) UNSIGNED DEFAULT NULL,
  `solar_radiation` smallint(6) UNSIGNED DEFAULT NULL,
  `solar_high` smallint(6) UNSIGNED DEFAULT NULL,
  `temp_leaf_0` decimal(4,1) DEFAULT NULL,
  `temp_leaf_1` decimal(4,1) DEFAULT NULL,
  `wet_leaf_0` tinyint(4) UNSIGNED DEFAULT NULL,
  `wet_leaf_1` tinyint(4) UNSIGNED DEFAULT NULL,
  `temp_soil_0` decimal(4,1) DEFAULT NULL,
  `temp_soil_1` decimal(4,1) DEFAULT NULL,
  `temp_soil_2` decimal(4,1) DEFAULT NULL,
  `temp_soil_3` decimal(4,1) DEFAULT NULL,
  `hum_extra_0` tinyint(3) UNSIGNED DEFAULT NULL,
  `hum_extra_1` tinyint(3) UNSIGNED DEFAULT NULL,
  `temp_extra_0` decimal(4,1) DEFAULT NULL,
  `temp_extra_1` decimal(4,1) DEFAULT NULL,
  `temp_extra_2` decimal(4,1) DEFAULT NULL,
  `soil_moist_0` tinyint(3) UNSIGNED DEFAULT NULL,
  `soil_moist_1` tinyint(3) UNSIGNED DEFAULT NULL,
  `soil_moist_2` tinyint(3) UNSIGNED DEFAULT NULL,
  `soil_moist_3` tinyint(3) UNSIGNED DEFAULT NULL,
  `forecast_rule` tinyint(3) UNSIGNED DEFAULT NULL,
  `wind_samples` smallint(5) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `rtd`
--

CREATE TABLE `rtd` (
  `rtd_id` bigint(20) NOT NULL,
  `wid` bigint(20) UNSIGNED NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `time_utc` int(10) UNSIGNED NOT NULL,
  `time_loc` time NOT NULL,
  `date_loc` date NOT NULL,
  `barometer` decimal(5,3) DEFAULT NULL,
  `altimeter` decimal(5,3) DEFAULT NULL,
  `raw_bar` decimal(5,3) DEFAULT NULL,
  `bar_trend` tinyint(3) DEFAULT NULL,
  `temp_out` decimal(4,1) DEFAULT NULL,
  `temp_in` decimal(4,1) DEFAULT NULL,
  `hum_out` tinyint(3) UNSIGNED DEFAULT NULL,
  `hum_in` tinyint(3) UNSIGNED DEFAULT NULL,
  `wind_spd` decimal(4,1) DEFAULT NULL,
  `wind_dir` smallint(6) UNSIGNED DEFAULT NULL,
  `wind_avg_2min` decimal(4,1) DEFAULT NULL,
  `wind_avg_10min` decimal(4,1) DEFAULT NULL,
  `wind_gust_10min` decimal(4,1) DEFAULT NULL,
  `wind_gust_dir` smallint(5) UNSIGNED DEFAULT NULL,
  `rain_rate` decimal(10,5) DEFAULT NULL,
  `rain_15min` decimal(10,5) DEFAULT NULL,
  `rain_1h` decimal(10,5) DEFAULT NULL,
  `rain_day` decimal(10,5) DEFAULT NULL,
  `rain_daily` decimal(10,5) DEFAULT NULL,
  `rain_24` decimal(10,5) DEFAULT NULL,
  `rain_month` decimal(10,5) DEFAULT NULL,
  `rain_year` decimal(10,5) DEFAULT NULL,
  `storm_rain` decimal(10,5) DEFAULT NULL,
  `storm_date` decimal(10,5) DEFAULT NULL,
  `dew_point` decimal(4,1) DEFAULT NULL,
  `dew_point_cal` decimal(4,1) DEFAULT NULL,
  `wind_chill` decimal(4,1) DEFAULT NULL,
  `heat_index` decimal(4,1) DEFAULT NULL,
  `thsw_index` decimal(10,5) DEFAULT NULL,
  `solar_radiation` smallint(5) UNSIGNED DEFAULT NULL,
  `uv` tinyint(3) UNSIGNED DEFAULT NULL,
  `et_day` decimal(10,5) DEFAULT NULL,
  `et_month` decimal(10,5) DEFAULT NULL,
  `et_year` decimal(10,5) DEFAULT NULL,
  `temp_extra_0` decimal(4,1) DEFAULT NULL,
  `temp_extra_1` decimal(4,1) DEFAULT NULL,
  `temp_extra_2` decimal(4,1) DEFAULT NULL,
  `temp_extra_3` decimal(4,1) DEFAULT NULL,
  `temp_extra_4` decimal(4,1) DEFAULT NULL,
  `temp_extra_5` decimal(4,1) DEFAULT NULL,
  `temp_extra_6` decimal(4,1) DEFAULT NULL,
  `hum_extra_0` tinyint(3) UNSIGNED DEFAULT NULL,
  `hum_extra_1` tinyint(3) UNSIGNED DEFAULT NULL,
  `hum_extra_2` tinyint(3) UNSIGNED DEFAULT NULL,
  `hum_extra_3` tinyint(3) UNSIGNED DEFAULT NULL,
  `hum_extra_4` tinyint(3) UNSIGNED DEFAULT NULL,
  `hum_extra_5` tinyint(3) UNSIGNED DEFAULT NULL,
  `hum_extra_6` tinyint(3) UNSIGNED DEFAULT NULL,
  `temp_soil_0` decimal(4,1) DEFAULT NULL,
  `temp_soil_1` decimal(4,1) DEFAULT NULL,
  `temp_soil_2` decimal(4,1) DEFAULT NULL,
  `temp_soil_3` decimal(4,1) DEFAULT NULL,
  `temp_leaf_0` decimal(4,1) DEFAULT NULL,
  `temp_leaf_1` decimal(4,1) DEFAULT NULL,
  `temp_leaf_2` decimal(4,1) DEFAULT NULL,
  `temp_leaf_3` decimal(4,1) DEFAULT NULL,
  `wet_leaf_0` tinyint(3) UNSIGNED DEFAULT NULL,
  `wet_leaf_1` tinyint(3) UNSIGNED DEFAULT NULL,
  `wet_leaf_2` tinyint(3) UNSIGNED DEFAULT NULL,
  `wet_leaf_3` tinyint(3) UNSIGNED DEFAULT NULL,
  `soil_moist_0` tinyint(3) UNSIGNED DEFAULT NULL,
  `soil_moist_1` tinyint(3) UNSIGNED DEFAULT NULL,
  `soil_moist_2` tinyint(3) UNSIGNED DEFAULT NULL,
  `soil_moist_3` tinyint(3) UNSIGNED DEFAULT NULL,
  `stations_batt_status` tinyint(3) UNSIGNED DEFAULT NULL,
  `console_batt` decimal(3,2) DEFAULT NULL,
  `forecast_icon` tinyint(3) UNSIGNED DEFAULT NULL,
  `forecast_rule` tinyint(3) UNSIGNED DEFAULT NULL,
  `sunrise_loc_time` time DEFAULT NULL,
  `sunset_loc_time` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `wifiloggers`
--

CREATE TABLE `wifiloggers` (
  `id` int(10) UNSIGNED NOT NULL,
  `wid` bigint(20) UNSIGNED NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `station_name` varchar(48) DEFAULT NULL,
  `station_model` tinyint(3) UNSIGNED DEFAULT NULL,
  `station_fw_ver` decimal(4,2) DEFAULT NULL,
  `station_lati` decimal(4,1) DEFAULT NULL,
  `station_longi` decimal(4,1) DEFAULT NULL,
  `station_elevation` decimal(5,1) DEFAULT NULL,
  `station_bar_red_met` tinyint(4) DEFAULT NULL,
  `station_time_zone` tinyint(4) DEFAULT NULL,
  `station_units` tinyint(3) UNSIGNED DEFAULT NULL,
  `station_setup_bits` tinyint(4) UNSIGNED DEFAULT NULL,
  `station_rain_season_start` tinyint(4) UNSIGNED DEFAULT NULL,
  `station_archive_period` tinyint(4) UNSIGNED DEFAULT NULL,
  `station_wind_cup_size` tinyint(4) UNSIGNED DEFAULT NULL,
  `station_log_avg_temp` tinyint(4) UNSIGNED DEFAULT NULL,
  `station_usetx` tinyint(4) UNSIGNED DEFAULT NULL,
  `station_retransmit_tx` tinyint(4) UNSIGNED DEFAULT NULL,
  `station_daylight_m_a` tinyint(4) UNSIGNED DEFAULT NULL,
  `station_daylight_saving` tinyint(4) UNSIGNED DEFAULT NULL,
  `station_transmitter_1` smallint(6) UNSIGNED DEFAULT NULL,
  `station_transmitter_2` smallint(6) UNSIGNED DEFAULT NULL,
  `station_transmitter_3` smallint(6) UNSIGNED DEFAULT NULL,
  `station_transmitter_4` smallint(6) UNSIGNED DEFAULT NULL,
  `station_transmitter_5` smallint(6) UNSIGNED DEFAULT NULL,
  `station_transmitter_6` smallint(6) UNSIGNED DEFAULT NULL,
  `station_transmitter_7` smallint(6) UNSIGNED DEFAULT NULL,
  `station_transmitter_8` smallint(6) UNSIGNED DEFAULT NULL,
  `rtd_int` smallint(11) UNSIGNED DEFAULT NULL,
  `wfl_mac_st` varchar(20) DEFAULT NULL,
  `wfl_mac_ap` varchar(20) DEFAULT NULL,
  `wfl_time_loc` int(10) UNSIGNED DEFAULT NULL,
  `wfl_time_utc` int(10) UNSIGNED DEFAULT NULL,
  `wfl_lastboot` int(10) UNSIGNED DEFAULT NULL,
  `wfl_uptime` int(10) UNSIGNED DEFAULT NULL,
  `wfl_ip` varchar(20) DEFAULT NULL,
  `wfl_ssid` varchar(20) DEFAULT NULL,
  `wfl_rssi` decimal(4,0) DEFAULT NULL,
  `wfl_wifi_mode` tinyint(3) UNSIGNED DEFAULT NULL,
  `wfl_model` varchar(20) DEFAULT NULL,
  `wfl_ver` varchar(6) DEFAULT NULL,
  `wfl_lati` decimal(10,7) DEFAULT NULL,
  `wfl_longi` decimal(10,7) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hilowex`
--
ALTER TABLE `hilowex`
  ADD PRIMARY KEY (`hlex_id`),
  ADD UNIQUE KEY `Last HiLowex stay in DB` (`wid`,`date_loc`);

--
-- Indexes for table `hilows`
--
ALTER TABLE `hilows`
  ADD PRIMARY KEY (`hl_id`),
  ADD UNIQUE KEY `Last HiLow stay in DB` (`wid`,`date_loc`);

--
-- Indexes for table `logger`
--
ALTER TABLE `logger`
  ADD PRIMARY KEY (`log_id`),
  ADD UNIQUE KEY `davis_timestamp` (`wid`,`davis_timestamp`) USING BTREE;

--
-- Indexes for table `rtd`
--
ALTER TABLE `rtd`
  ADD PRIMARY KEY (`rtd_id`),
  ADD UNIQUE KEY `Only one WiFilogger` (`wid`);

--
-- Indexes for table `wifiloggers`
--
ALTER TABLE `wifiloggers`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD UNIQUE KEY `wfl_id` (`wid`),
  ADD UNIQUE KEY `ID` (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hilowex`
--
ALTER TABLE `hilowex`
  MODIFY `hlex_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hilows`
--
ALTER TABLE `hilows`
  MODIFY `hl_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `logger`
--
ALTER TABLE `logger`
  MODIFY `log_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rtd`
--
ALTER TABLE `rtd`
  MODIFY `rtd_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `wifiloggers`
--
ALTER TABLE `wifiloggers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `hilowex`
--
ALTER TABLE `hilowex`
  ADD CONSTRAINT `hilowex_ibfk_1` FOREIGN KEY (`wid`) REFERENCES `wifiloggers` (`wid`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `hilows`
--
ALTER TABLE `hilows`
  ADD CONSTRAINT `hilows_ibfk_1` FOREIGN KEY (`wid`) REFERENCES `wifiloggers` (`wid`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `logger`
--
ALTER TABLE `logger`
  ADD CONSTRAINT `logger_ibfk_1` FOREIGN KEY (`wid`) REFERENCES `wifiloggers` (`wid`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `rtd`
--
ALTER TABLE `rtd`
  ADD CONSTRAINT `rtd_ibfk_1` FOREIGN KEY (`wid`) REFERENCES `wifiloggers` (`wid`) ON DELETE CASCADE ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
