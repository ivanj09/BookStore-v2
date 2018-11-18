package model;

import java.util.ArrayList;

import com.google.gson.annotations.Expose;
import com.google.gson.annotations.SerializedName;

public class BookResponse {
	@SerializedName("items")
	@Expose
	private ArrayList<Book> books;
	
	public ArrayList<Book> getBooks(){
		return books;
	}
}
