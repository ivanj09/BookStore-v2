import ws.*;

import javax.xml.ws.Endpoint;

public class Main {
	public static void main(String[] args) {
		try {
			Endpoint.publish("http://localhost:4789/services/search", new SearchServiceImpl());	
			Endpoint.publish("http://localhost:4789/services/order", new OrderServiceImpl());		
			Endpoint.publish("http://localhost:4789/services/recommendation", new RecommendationServiceImpl());		
		} catch(Exception e) {
			System.out.println(e.getMessage());
		}
	}
}
