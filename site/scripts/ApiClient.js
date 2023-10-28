
/**
 * Result for API operations (such as adding/editing)
 * @typedef {object} ApiResult
 * @property {boolean} success
 * @property {string} info Information about the result (such as error message)
 */

/**
 * Result for API methods that return a single data object
 * @typedef {object} ApiObjectResult
 * @property {boolean} success
 * @property {string} info Information about the result (such as error message)
 * @property {object} object Fetched data object
 */

/**
 * Result for API methods that return an array of data
 * @typedef {object} ApiDataResult
 * @property {boolean} success
 * @property {string} info Information about the result (such as error message)
 * @property {object[]} data Fetched data array
 */

class API {
    static async #request(moduleName, methodName, params = {}) {
        if(!moduleName || !methodName) {
            return null;
        }
        console.log(params);
        return new Promise((resolve) => {
            $.ajax({
                url: `${API_PATH}/${moduleName}/${methodName}`,
                data: params,
            })
            .then(result => {
                console.log(result);
                try {
                    resolve(JSON.parse(result));
                }
                catch {
                    resolve(result);
                }
            })
            .catch(result => {
                console.log(result);
                try {
                    resolve(JSON.parse(result));
                }
                catch {
                    resolve(result);
                }
            })
        })
    }

    static Countries = {
        /** @returns {{success: boolean, info: string, object: object}} */
        get: (country_id) => this.#request("country", "get", { country_id }),
        /** @returns {{success: boolean, info: string, data: object[]}} */
        getList: () => this.#request("country", "get_list"),
    }
}

