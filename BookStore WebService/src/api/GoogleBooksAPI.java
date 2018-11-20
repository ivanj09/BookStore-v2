package api;

import utility.NetworkUtil;

import java.lang.reflect.Type;
import java.net.URI;
import java.util.ArrayList;
import java.util.Random;

import org.apache.http.client.utils.URIBuilder;

import com.google.gson.Gson;
import com.google.gson.reflect.TypeToken;

import database.BookDbHelper;
import model.Book;
import model.BookResponse;

public class GoogleBooksAPI {
	private final static String API_KEY = "AIzaSyCr4hc2SGelEmhfL2Wqo_dcdWZQvx9I4R4";
	private final static String SCHEME = "https";
	private final static String BASE_URL = "www.googleapis.com";
	private final static String SEARCH_BOOK_BY_VOLUME = "books/v1/volumes";
	private final static String QUERY_PARAM = "q";
	private final static String SEARCH_BY_CATEGORY = "subject:";
	private final static String KEY_PARAM = "key";
	
	public static String getJsonBooks(String title) {
		URI uri;
		try {
			uri = new URIBuilder()
				.setScheme(SCHEME)
				.setHost(BASE_URL)
				.setPath(SEARCH_BOOK_BY_VOLUME)
				.setParameter(QUERY_PARAM, title)
				.setParameter(KEY_PARAM, API_KEY).build();
			
			System.out.println(uri.toString());
			
			//Get response
			String response =  NetworkUtil.doRequest(uri).toString();
			
			//Mapping from json to data class
			Gson gson = new Gson();
			BookResponse bookResponse = gson.fromJson(response,  BookResponse.class);
			ArrayList<Book> books = bookResponse.getBooks();
			
			//Add price and quantity from db to books (from GBooks API)
			BookDbHelper db = new BookDbHelper();
			
			for (Book book : books) {
				float price = db.getPriceWhereBookId(book.getId());
				int quantity = db.getQuantityWhereBookId(book.getId());
				
				book.getVolumeInfo().setPrice(price);
				book.getVolumeInfo().setQuantity(quantity);
			}
			
			//Remove unused data
			Type listBookType = new TypeToken<ArrayList<Book>>() {}.getType();

			return gson.toJson(books, listBookType);
		} catch (Exception e) {
			System.out.println(e.getMessage());
			return null;
		}
	}
	
	public static String getJsonBookDetails(String id) {
		URI uri;
		try {
			uri = new URIBuilder()
					.setScheme(SCHEME)
					.setHost(BASE_URL)
					.setPath(SEARCH_BOOK_BY_VOLUME + "/" + id)
					.addParameter(KEY_PARAM, API_KEY)
					.build();
			
			//Get response
			String response = NetworkUtil.doRequest(uri);
			
			//Mapping from json to data class
			Gson gson = new Gson();
			Book book = gson.fromJson(response, Book.class);
			
			//Add price and quantity from db to book (from GBooks API)
			BookDbHelper db = new BookDbHelper();
			
			float price = db.getPriceWhereBookId(book.getId());
			int quantity = db.getQuantityWhereBookId(book.getId());
			
			book.getVolumeInfo().setPrice(price);
			book.getVolumeInfo().setQuantity(quantity);
			
			Type bookType = new TypeToken<Book>() {}.getType();
			
			return gson.toJson(book, bookType);
		} catch (Exception e) {
			System.out.println(e.getMessage());
			return null;
		}
	}
	
	public static Book getBookDetail(String id) {
		URI uri;
		try {
			uri = new URIBuilder()
					.setScheme(SCHEME)
					.setHost(BASE_URL)
					.setPath(SEARCH_BOOK_BY_VOLUME + "/" + id)
					.addParameter(KEY_PARAM, API_KEY)
					.build();
			
			//Get response
			String response = NetworkUtil.doRequest(uri);
			
			//Mapping from json to data class
			Gson gson = new Gson();
			Book book = gson.fromJson(response, Book.class);
			
			//Add price and quantity from db to book (from GBooks API)
			BookDbHelper db = new BookDbHelper();
			
			float price = db.getPriceWhereBookId(book.getId());
			int quantity = db.getQuantityWhereBookId(book.getId());
			
			book.getVolumeInfo().setPrice(price);
			book.getVolumeInfo().setQuantity(quantity);
			
			return book;
		} catch (Exception e) {
			System.out.println(e.getMessage());
			return null;
		}
	}
	
	public static Book getRandomBookByCategory(String category) {
		URI uri;
		try {
			uri = new URIBuilder()
				.setScheme(SCHEME)
				.setHost(BASE_URL)
				.setPath(SEARCH_BOOK_BY_VOLUME)
				.setParameter(QUERY_PARAM, SEARCH_BY_CATEGORY + category)
				.setParameter(KEY_PARAM, API_KEY).build();
			
			//Get response
			String response = NetworkUtil.doRequest(uri);
			
			//Mapping from json to data class
			Gson gson = new Gson();
			BookResponse bookResponse = gson.fromJson(response,  BookResponse.class);
			ArrayList<Book> books = bookResponse.getBooks();
			
			//Get random book from books
			return books.get(new Random().nextInt(books.size()));
		} catch (Exception e) {
			System.out.println(e.getMessage());
			return null;
		}
	}
	
	public static ArrayList<Book> getBooks(String title) {
		URI uri;
		try {
			uri = new URIBuilder()
				.setScheme(SCHEME)
				.setHost(BASE_URL)
				.setPath(SEARCH_BOOK_BY_VOLUME)
				.setParameter(QUERY_PARAM, title)
				.setParameter(KEY_PARAM, API_KEY).build();
			
			System.out.println(uri.toString());
			
			//Get response
			String response =  NetworkUtil.doRequest(uri).toString();
			
			//Mapping from json to data class
			Gson gson = new Gson();
			BookResponse bookResponse = gson.fromJson(response,  BookResponse.class);
			ArrayList<Book> books = bookResponse.getBooks();
			
			//Add price and quantity from db to books (from GBooks API)
			BookDbHelper db = new BookDbHelper();
			
			for (Book book : books) {
				float price = db.getPriceWhereBookId(book.getId());
				int quantity = db.getQuantityWhereBookId(book.getId());
				
				book.getVolumeInfo().setPrice(price);
				book.getVolumeInfo().setQuantity(quantity);
			}
			
			return books;
		} catch (Exception e) {
			System.out.println(e.getMessage());
			return null;
		}
	}
}
