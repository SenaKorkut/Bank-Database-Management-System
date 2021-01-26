import java.sql.*;

public class Main {
    public static void main(String[] args) {

        try {

            Class.forName("com.mysql.cj.jdbc.Driver");
            System.out.println("Connecting to a selected database...");
            Connection connection = DriverManager.getConnection("jdbc:mysql://dijkstra.ug.bcc.bilkent.edu.tr", "sena.korkut","KcAWEeki");
            Statement statement = connection.createStatement();

            System.out.println("Starting to remove previous tables if exists...");
            statement.executeUpdate("CREATE DATABASE IF NOT EXISTS sena_korkut");
            statement.executeUpdate("USE sena_korkut");
            statement.executeUpdate("DROP TABLE IF EXISTS owns");
            statement.executeUpdate("DROP TABLE IF EXISTS customer");
            statement.executeUpdate("DROP TABLE IF EXISTS account");

            System.out.println("Removed");

            String customer = "CREATE TABLE customer " +
                    "(cid CHAR(12)," +
                    "name VARCHAR(50)," +
                    "bdate DATE," +
                    "profession VARCHAR(25)," +
                    "address VARCHAR(50)," +
                    "city VARCHAR(20)," +
                    "nationality VARCHAR(20)," +
                    "PRIMARY KEY(cid))";
            statement.executeUpdate(customer);
            String account = "CREATE TABLE account " +
                    "(aid CHAR(8), " +
                    "branch VARCHAR(20), " +
                    "balance FLOAT," +
                    "openDate DATE," +
                    "PRIMARY KEY(aid))";

            statement.executeUpdate(account);


            String owns = "CREATE TABLE owns " +
                    "(cid CHAR(12), " +
                    "aid CHAR(8)," +
                    "PRIMARY KEY(cid,aid)," +
                    "FOREIGN KEY (cid) REFERENCES customer(cid) ON DELETE CASCADE," +
                    "FOREIGN KEY (aid) REFERENCES account(aid) ON DELETE CASCADE)";

            statement.executeUpdate(owns);


            String customerTable = "INSERT INTO customer VALUES" +
                    "(20000001, 'Cem', '1980-10-10', 'Engineer', 'Tunali', 'Ankara', 'TC')," +
                    "(20000002, 'Asli', '1985-09-08', 'Teacher', 'Nisantasi', 'Istanbul', 'TC')," +
                    "(20000003, 'Ahmet', '1995-02-11', 'Salesman', 'Karsiyaka', 'Izmir', 'TC')," +
                    "(20000004, 'John', '1990-04-16', 'Architect', 'Kizilay', 'Ankara', 'ABD');";


            statement.executeUpdate(customerTable);

            String accountTable = "INSERT INTO account VALUES" +
                    "('A0000001', 'Kizilay', 2000.00, '2009-01-01')," +
                    "('A0000002', 'Bilkent', 8000.00, '2011-01-01')," +
                    "('A0000003', 'Cankaya', 4000.00, '2012-01-01')," +
                    "('A0000004', 'Sincan', 1000.00, '2012-01-01')," +
                    "('A0000005', 'Tandogan', 3000.00, '2013-01-01')," +
                    "('A0000006', 'Eryaman', 5000.00, '2015-01-01')," +
                    "('A0000007', 'Umitkoy', 6000.00, '2017-01-01');";


            statement.executeUpdate(accountTable);

            String ownsTable = "INSERT INTO owns VALUES" +
                    "(20000001, 'A0000001')," +
                    "(20000001, 'A0000002')," +
                    "(20000001, 'A0000003')," +
                    "(20000001, 'A0000004')," +
                    "(20000002, 'A0000002')," +
                    "(20000002, 'A0000003')," +
                    "(20000002, 'A0000005')," +
                    "(20000003, 'A0000006')," +
                    "(20000003, 'A0000007')," +
                    "(20000004, 'A0000006');";
            statement.executeUpdate(ownsTable);

            String customerQ = "SELECT * FROM customer";
            ResultSet rs = statement.executeQuery(customerQ);
            System.out.println("cid \t name \t bdate \t profession \t address \t city \t nationality");
            while (rs.next()) {
                String cid = rs.getString("cid");
                String name =rs.getString("name");
                String bdate = rs.getString("bdate");
                String profession =rs.getString("profession");
                String address = rs.getString("address");
                String city =rs.getString("city");
                String nationality =rs.getString("nationality");
                System.out.println(cid +"\t"+ name +"\t"+ bdate +"\t"+ profession +"\t"+ address +"\t"+ city+"\t"+ nationality +"\t");
            }
            String accountQ = "SELECT * FROM account";
            ResultSet rs1 = statement.executeQuery(accountQ);
            System.out.println("aid \t branch \t balance \t openDate");
            while (rs1.next()) {
                String aid = rs1.getString("aid");
                String branch =rs1.getString("branch");
                String balance = rs1.getString("balance");
                String openDate =rs1.getString("openDate");
                System.out.println(aid +"\t"+ branch +"\t"+ balance +"\t"+ openDate +"\t");
            }
            String ownsQ = "SELECT * FROM owns";
            ResultSet rs2 = statement.executeQuery(ownsQ);
            System.out.println("cid \t\t aid");
            while (rs2.next()) {
                String cid = rs2.getString("cid");
                String aid =rs2.getString("aid");
                System.out.println(cid +"\t"+ aid);
            }


        } catch (SQLException | ClassNotFoundException e) {
            System.err.println("Connection Error");
            e.printStackTrace();
        }
    }
}
