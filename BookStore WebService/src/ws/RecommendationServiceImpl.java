package ws;

import javax.jws.WebService;

import com.google.gson.Gson;
import com.google.gson.reflect.TypeToken;

import api.GoogleBooksAPI;
import database.BookDbHelper;
import model.Book;

import java.lang.reflect.Type;
import java.sql.SQLException;
import java.util.ArrayList;

@WebService(endpointInterface = "ws.RecommendationService")
public final class RecommendationServiceImpl implements RecommendationService {

	@Override
	public String getRecommendedBooks(String[] categories) {
		//Get connection instance
		BookDbHelper db = new BookDbHelper();
		Book book;
		
		ArrayList<Book> books = new ArrayList<Book>();
		for (String category: categories) {
			String id = null;
			try {
				id = db.getTopBookWhereCategory(category);
			} catch (SQLException e) {
				e.printStackTrace();
			}
			
			if (id == null) {
				//Get random book with given category
				book = GoogleBooksAPI.getRandomBookByCategory(category);
				books.add(book);
			} else {
				book = GoogleBooksAPI.getBookDetail(id);
				books.add(book);
			}
		}
		
		Gson gson = new Gson();
		Type listBookType = new TypeToken<ArrayList<Book>>() {}.getType();
		
		return gson.toJson(books, listBookType);
	}

}
