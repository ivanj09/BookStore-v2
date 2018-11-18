package model;

import com.google.gson.annotations.Expose;
import com.google.gson.annotations.SerializedName;

public class SaleInfo {
	class RetailPrice{
		@SerializedName("amount")
		@Expose
		private int amount;
		
		@SerializedName("currencyCode")
		@Expose
		private String currencyCode;
		
		public int getAmount() {
			return amount;
		}
		
		public String getCurrencyCode() {
			return currencyCode;
		}
	}
	
	@SerializedName("retailPrice")
	@Expose
	private RetailPrice retailPrice;
	
	public RetailPrice getRetailPrice() {
		return retailPrice;
	}
}
