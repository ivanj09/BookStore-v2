import ws.*;
import javax.xml.ws.Endpoint;

public class Main {
	public static void main(String[] args) {
		try {
			Endpoint.publish("http://localhost:4789/services/order", new OrderServiceImpl());		
		} catch(Exception e) {
			System.out.println(e.getMessage());
		}
	}
}
