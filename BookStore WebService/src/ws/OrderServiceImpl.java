package ws;

import java.sql.SQLException;
import java.util.Date;

import javax.jws.WebService;

import api.GoogleBooksAPI;
import database.BookDbHelper;
import model.Book;

@WebService(endpointInterface = "ws.OrderService")
public final class OrderServiceImpl implements OrderService {

	@Override
	public String order(int userId, String bookId, int quantity, int accountNumber) {
		boolean success;
		
		/** Check user's balance, if greater or equal than price of ordered books then buy it..
			Need to check Bank WebService from accountNumber
		**/
		
		//Assume that user's order always success (because Bank WebService is not ready yet)
		success = true;
		if (success) {
			Date date = new Date();
			java.sql.Date sqlDate = new java.sql.Date(date.getTime());
			
			Book book = GoogleBooksAPI.getBookDetail(bookId);
			
			//Connect to db
			BookDbHelper db = new BookDbHelper();
			
			//Insert new dummy data order
			String[] categories = book.getVolumeInfo().getCategories();
			for (String category: categories) {
				try {
					db.insertOrder(userId, bookId, category, quantity, sqlDate);
				} catch (SQLException e) {
					e.printStackTrace();
				}
			}
			
			return "{\"success\":1}";
		}
		
		return "{\"success\":0}";
	}

}
