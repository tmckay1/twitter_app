/**
 * @class TwitterResponse
 *
 * This class encapulates a response from the twitter API
 */
class TwitterResponse {



	/**
	 * Default constructor
	 *
	 * @param TwitterError searchError  Error from the response, if any
	 * @param Object       responseData Raw response data
	 */
	constructor(searchError, responseData){
		this.searchError  = searchError;  
		this.responseData = responseData; 
	}
}



/**
 * @class TwitterError
 *
 * Represents an error received from the API
 */
class TwitterError {



	/**
	 * Default constructor
	 *
	 * @param int    errorCode Error code
	 * @param string errorMsg  User friendly message explaining error
	 */
	constructor(errorCode, errorMsg){
		this.errorCode = errorCode;
		this.errorMsg  = errorMsg;
	}



	/**
	 * Get the error code representing a can't find location
	 *
	 * @return int error code
	 */
	getLocationErrorCode(){
		return 3;
	}
}