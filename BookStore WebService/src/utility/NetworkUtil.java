package utility;

import java.net.HttpURLConnection;
import java.net.URI;
import java.net.URL;
import java.io.BufferedReader;
import java.io.InputStreamReader;

public class NetworkUtil {
	public static String doRequest(URI uri) throws Exception {
		//Experimental testing -> need to be delete soon..
		System.out.println(uri.toString());
		
		URL url = new URL(uri.toString());
		
		HttpURLConnection conn = (HttpURLConnection) url.openConnection();
		conn.setRequestMethod("GET");
		conn.setRequestProperty("Accept", "application/json");
		
		if (conn.getResponseCode() != 200) {
			throw new RuntimeException("Error when requesting to URL with Error Code: " + conn.getResponseCode());
		}
		
		BufferedReader reader = new BufferedReader(new InputStreamReader(conn.getInputStream()));
		String output = null;
		StringBuilder strBuf = new StringBuilder();  
		
		while ((output = reader.readLine()) != null)
			strBuf.append(output);
		
		return strBuf.toString();
	}
}
