package ws;

import javax.jws.WebService;

@WebService(endpointInterface = "ws.OrderService")
public final class OrderServiceImpl implements OrderService {

	@Override
	public String order(String id, String count, String accountNumber) {
		// TODO Auto-generated method stub
		return null;
	}

}
