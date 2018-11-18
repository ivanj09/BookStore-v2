package api;

import utility.NetworkUtil;

import java.net.URI;
import java.util.ArrayList;

import org.apache.http.client.utils.URIBuilder;

import com.google.gson.Gson;
import com.google.gson.GsonBuilder;

import model.Book;
import model.BookResponse;

public class GoogleBooksAPI {
	private final static String API_KEY = "AIzaSyCr4hc2SGelEmhfL2Wqo_dcdWZQvx9I4R4";
	private final static String SCHEME = "https";
	private final static String BASE_URL = "www.googleapis.com";
	private final static String SEARCH_BOOK_BY_VOLUME = "books/v1/volumes";
	private final static String QUERY_PARAM = "q";
	private final static String KEY_PARAM = "key";
	
	public static String getBooks(String title) {
		URI uri;
		try {
			uri = new URIBuilder()
				.setScheme(SCHEME)
				.setHost(BASE_URL)
				.setPath(SEARCH_BOOK_BY_VOLUME)
				.setParameter(QUERY_PARAM, title)
				.setParameter(KEY_PARAM, API_KEY).build();
			
			//Get response
			String data =  NetworkUtil.doRequest(uri).toString();
			
			//Mapping from json to data class
			Gson gson = new Gson();
			BookResponse bookResponse = gson.fromJson(data,  BookResponse.class);
			
			//Experimental testing -> need to be delete soon..
			ArrayList<Book> books = bookResponse.getBooks();
			for (Book book : books) {
				System.out.println(book.getVolumeInfo().getTitle());
			}
			
			return data;
		} catch (Exception e) {
			System.out.println(e.getMessage());
			System.out.println("error!!");
			return null;
		}
	}
	
}