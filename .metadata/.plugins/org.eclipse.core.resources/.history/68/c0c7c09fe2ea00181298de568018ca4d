package ws;

import javax.jws.WebService;

@WebService(endpointInterface = "ws.OrderService")
public class OrderServiceImpl implements OrderService{

	@Override
	public String[] getOrders() {
		return new String[] {"SSD", "VGA Graphic Card", "GPU"};
	}

	@Override
	public boolean addOrders(String order) {
		System.out.println("Saving new order: " + order);
		return true;
	}
}
