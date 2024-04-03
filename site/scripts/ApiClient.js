
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

    static Config = {
        PATH: "http://localhost:8080/webbutveckling/AlbumRatings/api/index.php",
        LOG_RESULTS: true,
    }
    /**
     * @param {string} moduleName Name of module (ex. Country, Album, Artist)
     * @param {string} methodName Name of method (ex. get, get_list, save)
     * @param {object|FormData} data API method parameters
     */
    static async #request(moduleName, methodName, data = {}) {

        const url = [this.Config.PATH, moduleName, methodName].filter(e => e).join("/");
        const logPath = url.replace(this.Config.PATH, "api");

        // Convert FormData to object
        if(data instanceof FormData) {
            const formDataObject = {};
            data.forEach(function(value, key){
                formDataObject[key] = value;
            });
            data = formDataObject;
        }

        var parseResult = (r) => {
            try {
                return (typeof r == "string" ? JSON.parse(r) :
                    r.hasOwnProperty("responseJSON") ? r.responseJSON : r);
            }
            catch {
                return r;
            }
        }

        return new Promise((resolve) => {
            $.ajax({ url, data })
            .then(r => {
                const result = parseResult(r);
                if(this.Config.LOG_RESULTS) console.log(logPath, result);
                resolve(result);
            })
            .catch(r => {
                const result = parseResult(r);
                if(this.Config.LOG_RESULTS) console.warn(logPath, result);
                alert(result.responseText || result.info || "Oopsie");
                resolve(result);
            })
        })
    }

    static Artists = {
        /** 
         * @param {number} id Artist ID
         * @returns {ApiObjectResult} 
         * */
        get: (id) => this.#request("artist", "get", { id }),
        /** 
         * @returns {ApiDataResult} 
         * */
        getList: () => this.#request("artist", "get_list"),
        /** 
         * @param {object} params
         * @param {number} [params.id] Artist ID (Insert new artist if unset)
         * @param {string} params.name
         * @param {string} params.description
         * @param {string} params.years_active
         * @returns {ApiResult} 
         * */
        save: (params) => this.#request("artist", "save", params),
        /**
         * @param {number} id Artist ID
         * @param {string} code Country code
         * @returns {ApiResult}
         */
        addCountry: (id, code) => this.#request("artist", "add_country", { id, code }),
        /**
         * @param {number} id Artist ID
         * @param {string} code Country code
         * @returns {ApiResult}
         */
        removeCountry: (id, code) => this.#request("artist", "remove_country", { id, code }),
    }

    static Countries = {
        /** 
         * @param {number} id Country ID
         * @returns {ApiObjectResult} 
         * */
        get: (id) => this.#request("country", "get", { id }),
        /** 
         * @returns {ApiDataResult} 
         * */
        getList: () => this.#request("country", "get_list"),
        /** 
         * @param {object} params
         * @param {number} [params.id] Country ID (Insert new country if unset)
         * @param {string} params.name Country Name
         * @returns {ApiResult} 
         * */
        save: (params) => this.#request("country", "save", params),
        /**
         * @param {string} value Search value
         * @returns {ApiDataResult}
         */
        search: (value) => this.#request("country", "search", { value }),
    }

    static Genres = {
        /** 
         * @param {number} id Genre ID
         * @returns {ApiObjectResult} 
         * */
        get: (id) => this.#request("genre", "get", { id }),
        /** 
         * @returns {ApiDataResult} 
         * */
        getList: () => this.#request("genre", "get_list"),
        /** 
         * @param {number} id Genre ID
         * @returns {ApiDataResult} 
         * */
        getSubgenres: (id) => this.#request("genre", "get_subgenres", { id }),
        /** 
         * @param {number} id Genre ID
         * @returns {ApiDataResult} 
         * */
        getSubgenreTree: (id) => this.#request("genre", "get_subgenre_tree", { id }),
        /** 
         * @param {number} id Genre ID
         * @returns {ApiDataResult} 
         * */
        getAncestors: (id) => this.#request("genre", "get_ancestors", { id }),
        /** 
         * @param {number} id Genre ID
         * @returns {ApiObjectResult} 
         * */
        getTopLevelGenre: (id) => this.#request("genre", "get_top_level_genre", { id }),
        /** 
         * @returns {ApiDataResult} 
         * */
        getAllTopLevelGenres: () => this.#request("genre", "get_all_top_level_genres"),
        /** 
         * @param {object} params
         * @param {number} [params.id] Genre ID (Insert new genre if unset)
         * @param {number} params.primary_genre_id Primary genre ID
         * @param {string} params.name Genre Name
         * @returns {ApiResult} 
         * */
        save: (params) => this.#request("genre", "save", params),
    }

    static Formats = {
        /** 
         * @param {number} id Format ID
         * @returns {ApiObjectResult} 
         * */
        get: (id) => this.#request("format", "get", { id }),
        /** 
         * @returns {ApiDataResult} 
         * */
        getList: () => this.#request("format", "get_list"),
        /** 
         * @param {object} params
         * @param {number} [params.id] Format ID (Insert new format if unset)
         * @param {string} params.name Format Name
         * @returns {ApiResult} 
         * */
        save: (params) => this.#request("format", "save", params),
    }
}

