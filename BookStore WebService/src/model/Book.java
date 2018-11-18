package model;

import com.google.gson.annotations.Expose;
import com.google.gson.annotations.SerializedName;

public class Book {
	@SerializedName("id")
	@Expose
	private String id;
	
	@SerializedName("volumeInfo")
	@Expose
	private VolumeInfo volInfo;
	
	@SerializedName("saleInfo")
	@Expose
	private SaleInfo saleInfo;
	
	public String getId() {
		return id;
	}
	
	public VolumeInfo getVolumeInfo() {
		return volInfo;
	}
	
	public SaleInfo getSaleInfo() {
		return saleInfo;
	}
}
