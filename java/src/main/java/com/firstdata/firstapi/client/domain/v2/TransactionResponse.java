package com.firstdata.firstapi.client.domain.v2;

import java.util.ArrayList;
import org.codehaus.jackson.annotate.JsonAutoDetect;
import org.codehaus.jackson.annotate.JsonIgnore;
import org.codehaus.jackson.annotate.JsonProperty;
import org.codehaus.jackson.annotate.JsonAutoDetect.Visibility;
@JsonAutoDetect(fieldVisibility = Visibility.ANY, getterVisibility = Visibility.NONE, setterVisibility = Visibility.NONE)
public class TransactionResponse {

    /**
     * {"method":"credit_card","amount":"1100","currency":"USD","avs":"Z","cvv2":"I",
     * "card":{"type":"visa","cvv":"123","cardholder_name":"Ritesh Shah","card_number":"8291","exp_date":"1214"},
     * "transaction_status":"approved","validation_status":"success","transaction_type":"PURCHASE",
     * "transaction_id":"OK3740","transaction_tag":"1597368","transarmor_token":"2537446225198291",
     * "correlation_id":"55.1410534812572"} 
     * */
	public TransactionResponse() {
	}
	
	@JsonProperty("transaction_status")
	private String transactionStatus;
	@JsonProperty("validation_status")
	private String validationStatus;
	@JsonProperty("transaction_type")
	private String transactionType;
	@JsonProperty("transaction_id")
	private String transactionId;
	@JsonProperty("transaction_tag")
	private String transactionTag;
	@JsonProperty("method")
	private String method;
	@JsonProperty("amount")
	private String amount;
	@JsonProperty("currency")
	private String currency;
	@JsonProperty("avs")	
	private String avs;
	@JsonProperty("cvv2")
	private String cvv2;
    @JsonProperty("transarmor_token")
	private String token;
    @JsonProperty("card")
    private Card card;
    @JsonProperty("Error")
    private Error error;
	@JsonProperty("correlation_id")
	private String correlationID;
	
	public String getTransactionStatus() {
		return transactionStatus;
	}

	
	public void setTransactionStatus(String transactionStatus) {
		this.transactionStatus = transactionStatus;
	}
	
	
	public String getValidationStatus() {
		return validationStatus;
	}

	
	public void setValidationStatus(String validationStatus) {
		this.validationStatus = validationStatus;
	}


	
	
	public String getTransactionType() {
		return transactionType;
	}


	
	public void setTransactionType(String transactionType) {
		this.transactionType = transactionType;
	}
	
	
	public String getTransactionId() {
		return transactionId;
	}

	
	public void setTransactionId(String transactionId) {
		this.transactionId = transactionId;
	}


	
	public String getTransactionTag() {
		return transactionTag;
	}


	
	public void setTransactionTag(String transactionTag) {
		this.transactionTag = transactionTag;
	}
	
	
	public String getMethod() {
		return method;
	}

	
	public void setMethod(String method) {
		this.method = method;
	}


	
	public String getAmount() {
		return amount;
	}


	
	public void setAmount(String amount) {
		this.amount = amount;
	}


	
	public String getCurrency() {
		return currency;
	}


	
	public void setCurrency(String currency) {
		this.currency = currency;
	}

	
	public String getAvs() {
		return avs;
	}


	
	public void setAvs(String avs) {
		this.avs = avs;
	}


	
	public String getCvv2() {
		return cvv2;
	}


	
	public void setCvv2(String cvv2) {
		this.cvv2 = cvv2;
	}




	public String getToken() {
		return token;
	}


	public void setToken(String token) {
		this.token = token;
	}

	
	public Card getCard() {
		return card;
	}


	
	public void setCard(Card card) {
		this.card = card;
	}


	
	public Error getError() {
		return error;
	}

	
	
	public void setErrMessage(ArrayList<String> messages){
		error= new Error();
		error.setMessage(messages);
	}


    
    public String getCorrelationID() {
        return correlationID;
    }


    
    public void setCorrelationID(String correlationID) {
        this.correlationID = correlationID;
    }


    
/*    public void setError(Error error) {
        this.error = error;
    }
*/

}
