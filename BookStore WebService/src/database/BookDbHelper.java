package database;

import java.sql.Connection;
import java.sql.Date;
import java.sql.DriverManager;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.sql.Statement;

public class BookDbHelper {
	private final static String JDBC_DRIVER = "com.mysql.jdbc.Driver";
	private final static String DB_URL = "jdbc:mysql://localhost:3306/book_ws_db";
	private final static String USER = "nuance";
	private final static String PASS = "Allofthings1";
	private final static String ORDER_TABLE = "orders";
	private final static String BOOK_TABLE = "books";
	private static Connection conn;
	
	private static Connection getConnectionInstance() {
		if (conn == null) {
			try {
	        	//Try to connect to db
	        	Class.forName(JDBC_DRIVER);
	    		conn = DriverManager.getConnection(DB_URL, USER, PASS);
	    		
	    		//If success
	            System.out.println(String.format("Connected to database %s "
	                    + "successfully.", conn.getCatalog()));
	            
	            //Create table if not exist
	            createOrderTableIfNotExist();
	            createBookTableIfNotExist();
	            
	        } catch (SQLException ex) {
	            System.out.println(ex.getMessage());
	        } catch (ClassNotFoundException ex) {
	        	System.out.println("Class not found");
			}
		}
		return conn;
	}
	
	private static void createOrderTableIfNotExist() throws SQLException {
	    String sqlCreate = "CREATE TABLE IF NOT EXISTS " + ORDER_TABLE
	            + "  (id				int(10) NOT NULL PRIMARY KEY AUTO_INCREMENT,"
	            + "   user_id			int(10),"
	            + "   book_id			varchar(255),"
	            + "   category			varchar(255),"
	            + "	  quantity			int(10),"	
	            + "   ordered_by		datetime)";

	    Statement stmt = conn.createStatement();
	    stmt.execute(sqlCreate);
	}
	
	private static void createBookTableIfNotExist() throws SQLException {
	    String sqlCreate = "CREATE TABLE IF NOT EXISTS " + BOOK_TABLE
	            + "  (id				int(10) NOT NULL PRIMARY KEY AUTO_INCREMENT,"
	            + "   book_id			varchar(255) UNIQUE,"
	            + "   quantity			int(10),"
	            + "   price				float(11,1))";

	    Statement stmt = conn.createStatement();
	    stmt.execute(sqlCreate);
	}
	
	public float getPriceWhereBookId(String bookId) throws SQLException {
		Connection conn = getConnectionInstance();
		PreparedStatement prepareStmt = null;
		
		
		//SQL statement
		String sql = "SELECT price FROM " + BookDbHelper.BOOK_TABLE
				+ " WHERE book_id = \"" + bookId + "\"";
		
		//Set prepared stmt
		prepareStmt = conn.prepareStatement(sql);
		
		//Get result 
		ResultSet rs = prepareStmt.executeQuery();
		
		return rs.next()? rs.getFloat("price"):0f;
	}
	
	public int getQuantityWhereBookId(String bookId) throws SQLException {
		Connection conn = getConnectionInstance();
		PreparedStatement prepareStmt = null;
		
		
		//SQL statement
		String sql = "SELECT quantity FROM " + BookDbHelper.BOOK_TABLE
				+ " WHERE book_id = \"" + bookId + "\"";
		
		//Set prepared stmt
		prepareStmt = conn.prepareStatement(sql);
		
		//Get result 
		ResultSet rs = prepareStmt.executeQuery();
		
		return rs.next()? rs.getInt("quantity"):0;
	}
	
	public String getTopBookWhereCategory(String category) throws SQLException {
		Connection conn = getConnectionInstance();
		PreparedStatement prepareStmt = null;
		
		//SQL statement
		String sql = "SELECT book_id, SUM(quantity) as total"
				+ " FROM " + BookDbHelper.ORDER_TABLE
				+ " WHERE category = \"" + category + "\""
				+ " GROUP BY book_id"
				+ " ORDER BY total DESC"
				+ " LIMIT 1";
		
		//Set prepared stmt
		prepareStmt = conn.prepareStatement(sql);
		
		//Get result 
		ResultSet rs = prepareStmt.executeQuery();
		
		//If exist
		if (rs.next()) {
			return rs.getString("book_id");
		}
		
		return null;
	}

	public void insertOrder(int i, String id, String category, int quantity, Date sqlDate) throws SQLException {
		Connection conn = getConnectionInstance();
		PreparedStatement prepareStmt = null;
		
		//SQL statement
		String sql = "INSERT INTO " + BookDbHelper.ORDER_TABLE 
				+ " (user_id, book_id, category, quantity, ordered_by)"
				+ " VALUES(?,?,?,?,?)";
	
		prepareStmt = conn.prepareStatement(sql);
		prepareStmt.setInt(1, i);
		prepareStmt.setString(2, id);
		prepareStmt.setString(3, category);
		prepareStmt.setInt(4, quantity);
		prepareStmt.setDate(5, sqlDate);
		
		prepareStmt.executeUpdate();
	}
}
