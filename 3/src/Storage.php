<?php

namespace IharKarpliuk\AmoPointThirdTest;

use PDO;

class Storage
{
    private PDO $db;
    private readonly string $tableName;

    public function __construct(
        string $dbPath,
    )
    {
        $this->db = new PDO("sqlite:$dbPath");
        $this->tableName = 'visits';
    }

    /**
     * Saves the IP, city, and device information to the database table.
     *
     * @param string $ip The IP address to be saved.
     * @param string $city The city to be saved.
     * @param string $device The device to be saved.
     */
    public function save(string $ip, string $city, string $device): void
    {
        $stmt = $this->db->prepare("INSERT INTO $this->tableName (ip, city, device) VALUES (:ip, :city, :device)");
        $stmt->bindValue(':ip', $ip);
        $stmt->bindValue(':city', $city);
        $stmt->bindValue(':device', $device);

        $stmt->execute();
    }

    /**
     * Retrieves the hourly visits from the database.
     * @return array An associative array containing the hourly visits.
     */
    public function getHourlyVisits(): array
    {
        return $this->db->query("SELECT strftime('%Y-%m-%d %H:00:00', visit_time) as hour, COUNT(*) as visits
                            FROM visits
                            GROUP BY hour")->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Retrieves the number of unique visits for each city.
     * @return array An associative array containing the number of unique visits for each city.
     */
    public function getCityVisits(): array
    {
        return $this->db->query("SELECT city, COUNT(*) as visits
                          FROM visits
                          GROUP BY city")->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Creates a table in the database if it does not already exist.
     */
    public function createTableIfNotExist(): void
    {
        $this->db->exec("CREATE TABLE IF NOT EXISTS $this->tableName(
                                id INTEGER PRIMARY KEY AUTOINCREMENT, 
                                ip VARCHAR NOT NULL,
                                city VARCHAR NOT NULL,
                                device VARCHAR NOT NULL,
                                visit_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP)");
    }
}