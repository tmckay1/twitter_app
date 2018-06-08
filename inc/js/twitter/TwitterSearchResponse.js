/**
 * @class TwitterSearchResponse
 *
 * This class encapulates a search response from the twitter API
 */
class TwitterSearchResponse {



	/**
	 * Default constructor
	 *
	 * @param TwitterSearchError searchError  Error from the response, if any
	 * @param Object             responseData Raw response data
	 */
	constructor(searchError, responseData){
		this.searchError  = searchError;  
		this.responseData = responseData; 
	}
}



/**
 * @class TwitterSearchError
 *
 * Represents an error received from the API
 */
class TwitterSearchError {



	/**
	 * Default constructor
	 *
	 * @param int    errorCode Error code, means nothing for now, can be expanded upon
	 * @param string errorMsg  User friendly message explaining error
	 */
	constructor(errorCode, errorMsg){
		this.errorCode = errorCode;
		this.errorMsg  = errorMsg;
	}
}