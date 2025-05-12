const defaultHeaders = {
  'Content-Type': 'application/json',
  'X-Requested-With': 'XmlHttpRequest',
  'Accept': 'application/json',
};

let defaultBaseUrl = '';

/**
 * Update the default headers
 * @param {Object} headers - Headers to merge with the defaults for all requests
 */
export function setDefaultHeaders(headers) {
  Object.assign(defaultHeaders, headers);
}

/**
 * Set the default base URL
 * @param {string} url - Base URL to use for all requests
 */
export function setDefaultBaseUrl(url) {
  if (url[url.length - 1] === '/') url = url.slice(0, -1);
  defaultBaseUrl = url;
}

/**
 * Perform an HTTP request with JSON support, timeout, and error handling
 *
 * @param {Object|string} options - Either a configuration object with request parameters, or a URL string (in which case defaults are applied to other parameters)
 * @param {string} options.url - Relative request URL (required)
 * @param {Object|null} [options.data=null] - Data to send (body or query string)
 * @param {string|null} [options.method=null] - HTTP method (GET, POST, etc.)
 * @param {Object} [options.headers={}] - Additional headers
 * @param {number} [options.timeout=5000] - Timeout in milliseconds
 * @param {string|null} [options.baseUrl=null] - Custom base URL for this request
 * @returns {Object} - { request: Promise, abort: Function }
 */
export function fetchJson(options) {
  if (typeof options === 'string') {
    options = { url: options };
  }

  const {
    url,
    data = null,
    method = null,
    headers = {},
    timeout = 5000,
    baseUrl = null,
  } = options;

  if (typeof url !== 'string') throw new Error('The URL must be a string.');
  const theMethod = method ? method.toUpperCase() : (data ? 'POST' : 'GET');

  let fullUrl;
  if (url.startsWith('http://') || url.startsWith('https://')) {
    fullUrl = url;
  } else {
    // Handle API URLs with parameters in the path
    let apiUrl = (baseUrl ?? defaultBaseUrl) + (url.startsWith('/') ? url : '/' + url);
    
    // Handle URL path parameters - replace {id} with actual ID value if provided in data
    if (data && Object.keys(data).length > 0 && apiUrl.includes('{')) {
      Object.keys(data).forEach(key => {
        const placeholder = `{${key}}`;
        if (apiUrl.includes(placeholder)) {
          apiUrl = apiUrl.replace(placeholder, data[key]);
          // Remove used path parameter from data object to avoid it being added to query string
          delete data[key];
        }
      });
    }
    
    fullUrl = apiUrl;
  }

  // Append ID to URL if it's a GET request and id is in the data
  if (theMethod === 'GET' && data && data.id && !fullUrl.endsWith(data.id)) {
    if (fullUrl.endsWith('/')) {
      fullUrl += data.id;
    } else {
      fullUrl += '/' + data.id;
    }
    // Remove id from data to avoid it being added to query string
    const newData = {...data};
    delete newData.id;
    data = newData;
  }

  if (theMethod === 'GET' && data && Object.keys(data).length > 0) {
    const queryString = new URLSearchParams(data).toString();
    fullUrl += (fullUrl.includes('?') ? '&' : '?') + queryString;
  }

  const allHeaders = { ...defaultHeaders, ...headers };

  const controller = new AbortController();
  const timeoutId = setTimeout(() => controller.abort(), timeout);
  const signal = controller.signal;

  const body = theMethod !== 'GET' && data ? JSON.stringify(data) : null;

  const request = new Promise((resolve, reject) => {
    fetch(fullUrl, { method: theMethod, headers: allHeaders, body, signal })
      .then(resp => {
        clearTimeout(timeoutId);
        const respClone = resp.clone();
        return resp.json()
          .then(data => {
            if (!resp.ok) {
              reject({ status: resp.status, statusText: resp.statusText, data });
            } else {
              resolve(data);
            }
          })
          .catch(() => {
            return respClone.text()
              .then(() => reject({
                status: resp.status,
                statusText: 'Error parsing response body as JSON',
                data: null,
              }))
              .catch(() => reject({
                  status: resp.status,
                  statusText: 'Error parsing response body',
                  data: null,
              }));
          });
      })
      .catch(err => {
        clearTimeout(timeoutId);
        if (err.name === 'AbortError') {
          reject({ status: 408, statusText: 'Request Timeout', data: null });
        } else if (err === 'AbortExternally') {
          reject({ status: 499, statusText: 'Client Closed Request', data: null });
        } else {
          reject({ status: 0, statusText: err.message || 'Unknown Network Error', data: null });
        }
      });
  });

  return {
    request,
    abort: () => controller.abort('AbortExternally'),
  };
}