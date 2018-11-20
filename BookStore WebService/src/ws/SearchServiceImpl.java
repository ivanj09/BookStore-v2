package ws;

import javax.jws.WebService;

import api.GoogleBooksAPI;

@WebService(endpointInterface = "ws.SearchService")
public final class SearchServiceImpl implements SearchService{

	@Override
	public String searchBooksByKeyword(String title) {
		return GoogleBooksAPI.getJsonBooks(title);
	}

	@Override
	public String getBookDetails(String id) {
		return GoogleBooksAPI.getJsonBookDetails(id);
	}
}
