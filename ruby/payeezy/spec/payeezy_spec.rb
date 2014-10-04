require 'spec_helper'

describe "Sample calls to Payeezy" do

  before :each do
    options = {}
    options[:url] = 'https://api-cert.payeezy.com/v1/transactions'
    options[:apikey] = 'y6pWAJNyJyjGv66IsVuWnklkKUPFbb0a'
    options[:apisecret] = '09730a91f4f055dd5d3878099644f2f60bf0a4421485f20af72076bbb0b41e96'
    options[:token] = 'fdoa-a480ce8951daa73262734cf102641994c1e55e7cdf4c02b6'

    @payeezy = Payeezy::Transactions.new options
  end

  describe "#new" do
    it 'returns an instance of Payeezy' do
      @payeezy.should be_an_instance_of Payeezy::Transactions
    end
  end

  describe "Execute Primary Transactions" do
    it 'Authorize Transaction' do
      @primary_response = @payeezy.transact(:authorize,primary_tx_payload)
      @primary_response['transaction_status'].should == "approved"
    end

    it 'Purchase Transaction' do
      @primary_response = @payeezy.transact(:purchase,primary_tx_payload)
      @primary_response['transaction_status'].should == "approved"
    end
  end

  describe "Execute Secondary Transactions" do
    it 'Capture Transaction' do
      @primary_response = @payeezy.transact(:authorize,primary_tx_payload)
      @primary_response['transaction_status'].should == "approved"
      @secondary_response = @payeezy.transact(:capture,secondary_tx_payload(@primary_response))
      @secondary_response['transaction_status'].should == "approved"
    end

    it 'Void Transaction' do
      @primary_response = @payeezy.transact(:authorize,primary_tx_payload)
      @primary_response['transaction_status'].should == "approved"
      @secondary_response = @payeezy.transact(:void,secondary_tx_payload(@primary_response))
      @secondary_response['transaction_status'].should == "approved"
    end

    it 'Refund Transaction' do
      @primary_response = @payeezy.transact(:purchase,primary_tx_payload)
      @primary_response['transaction_status'].should == "approved"
      @secondary_response = @payeezy.transact(:refund,secondary_tx_payload(@primary_response))
      @secondary_response['transaction_status'].should == "approved"
    end


  end

  def primary_tx_payload
    credit_card = {}
    payload = {}
    payload[:merchant_ref] = 'Astonishing-Sale'
    payload[:amount]='1299'
    payload[:currency_code]='USD'
    payload[:method]='credit_card'

    credit_card[:type] = 'visa'
    credit_card[:cardholder_name] = 'John Smith'
    credit_card[:card_number] = '4788250000028291'
    credit_card[:exp_date] = '1014'
    credit_card[:cvv] = '123'
    payload[:credit_card] = credit_card

    payload
  end

  def secondary_tx_payload(response)
    payload = {}
    payload[:merchant_ref] = 'Astonishing-Sale'
    payload[:transaction_tag] = response['transaction_tag']
    payload[:method]=response['method']
    payload[:amount]=response['amount']
    payload[:currency_code]=response['currency']
    payload[:transaction_id] = response['transaction_id']

    payload
  end

end