package ws;

import javax.jws.WebMethod;
import javax.jws.WebParam;
import javax.jws.WebService;
import javax.jws.soap.SOAPBinding;
import javax.jws.soap.SOAPBinding.Style;
import javax.xml.bind.annotation.XmlElement;

@WebService
@SOAPBinding(style = Style.RPC)
public interface RecommendationService {
	@WebMethod
	String getRecommendedBooks(@WebParam(name = "categories") @XmlElement(required = true) String[] categories);
}
