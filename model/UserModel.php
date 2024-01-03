<?php


class UserModel extends AppQuery
{
    protected $table = "users";
    const RSAKEY = "-----BEGIN RSA PRIVATE KEY-----
MIIEogIBAAKCAQEAgmqV10XX73Ba/Tbzen+cFoji0ZUWmFDtbhTQvBJMhcEuUtMm
TYx9YhyvPvbpctzF1nT8sEBFpp/MOMo4nrv7SmD0eCyRRaYVNWLxjXMWeJr8j8dq
xWT22mbQFRgwNtPlhKVauQyQinegfXzqUBhS713HAf/V0R8oGfRqRzGHQ8mRMUql
kBrPLrHrAi6Bqzfn/hVylhZsbNUay+YDaqEkt6ixDY91miGsc/z7T30We+7aa1nS
PPQ/zzrrKFK1SPqad/TrzRKDC94jqHiNhNsMl2pdiw/tZcIq5FJ87mT6I2F3sqvc
xNtwb3Z89qOMi5H1BHFeHfqEfkx4zJjBtvXQQQIDAQABAoIBABMq1xrsiPAH81eD
3AUE/EvTkoJ7Bvcb7clgBc2eYuDFo6lInziGjWb+EEOQxn67M9hxGTJOP+5dTgaK
sgeiWSx1U3jWFAPIhRVzlUzUvVi8bqIzDN42GJHAypRPGcb1HaaBJvRLhHLVYiEP
WuCqsoW7oqQIlcRGb/5gjb4o6Vhs8RqoZFGQicMMiJDlbdqBNfRIUc1kmTkWbynY
BKgd6RdiepoQ6/wOQVtiauQWTDqSJG0oi0iYdUFzEEm3jkl3CuF87DNeO7nYQkqA
bx+cNQR+nuLia8fPglZuYmmnWTc6zLAsvTot+okYx4bHcdVIXOQCcRIkecKltJj5
AdVO4AECgYEA108jhpp1PlSr/wohzKOtCB+XUDt82chXTtPMlWvi+1ObKAqmnRV7
y2MDluiGAcXT5+w6rxos6Qz68nrHB9Ii8znrGdBXkzEjCwkIy3pLbyjNReBePe43
cKZmG+/jD2wExqUPOYveEwPX8teMXNGJbaZRxN0uNEva/HZd7cxu0nECgYEAmxBA
qcBcjBQdbVAhJv981D3LXimGr5745lPDJNlArlpjztgUD3SkPzclc4nN0sZO2rOB
/vWaUdFWdqMhk+wRzAMlhdwiS+s1q6+GClUajGdJp1xp2pIIVN/ska8m1leTBPX4
/FdPUAyzXDTOPWvxFRJyYx/oEDhpNqGQBAOZItECgYBIs1cqjyMBjfOZpWEuSSIW
+RvNopiQrN4WJtwQpCI7fMqKJbaGmgd38JH4tcDx/kuEJzbVg0Ag3RorIBvuXx0g
BbGFwNyhPdk4U6+djUjFWwCdFJqdzL75kaYuzrxbq7ydGoTeiITO5OBZBkFF4hbG
aH95urlsPSTPVGR49CuDcQKBgFyXweUbhqfmwwOpW4KMASBDnhKmPVTVWs8+qUJx
sFvsgbjb8m6gOgu9hFGPsiXwYNnbYv657eJ5XGYPV1ebGa13G4rpPlmTJENW1nWJ
CAdbDfIwDs2DchIsfHkp28kWFiZaMsmL4UJtsxSWO6kVsanhkAh83vgAl2MV6odb
FrBhAoGAStuuQmTT4N+kagCfquemJDrx85eYyl8TuKd7ahctg0Z8M2v/u3MKn0OC
nG6IkfNut39ZEKQDMkft4y3mqJxRuvnsqXseLVS8JaNBo+AxSgL//tV7sdo29eSy
BnQBRbAzs0bnFNTqJZzkFCErP7QeImmK+bxFDbWHv/htNUygnIs=
-----END RSA PRIVATE KEY-----";
    public function getInfoUser($username)
    {
        return $this->getByUsername($username);
    }

    public function getByUsername($username)
    {
        try {
            $statement = $this->pdo->prepare("SELECT * FROM $this->table WHERE username = :username");
            $statement->bindParam(':username', $username);
            $statement->execute();
            $query = $statement->fetch(PDO::FETCH_ASSOC);
            return $query;
        } catch (\Throwable $th) {
            throw $th;
        }
    }
        public function totalUserRef($username)
    {
        try {
            $stmt = $this->pdo->prepare("SELECT COUNT(*) as total FROM users WHERE ref_user = :username");
            $stmt->bindParam(":username", $username);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result["total"];
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function totalBonus($username)
    {
        try {
            $stmt = $this->pdo->prepare("SELECT COALESCE(SUM(money), 0) as total_money FROM lichsuhoahong WHERE username = :username ");
            $stmt->bindParam(':username', $username);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['total_money'] ?  $result['total_money'] : 0;
        } catch (PDOException $e) {
            die("Querry ERRORR: " . $e->getMessage());
        }
    }
}
