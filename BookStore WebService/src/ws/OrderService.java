package ws;

import javax.jws.WebService;
import javax.jws.WebMethod;
import javax.jws.WebParam;
import javax.jws.soap.SOAPBinding;
import javax.jws.soap.SOAPBinding.Style;
import javax.xml.bind.annotation.XmlElement;

@WebService
@SOAPBinding(style = Style.RPC)
public interface OrderService {
	@WebMethod
	String order (@WebParam(name = "userId") @XmlElement(required = true) int userId, @WebParam(name = "bookId") @XmlElement(required = true) String bookId, @WebParam(name = "quantity") @XmlElement(required = true) int quantity, @WebParam(name = "accountNumber") @XmlElement(required = true) int accountNumber);
}
