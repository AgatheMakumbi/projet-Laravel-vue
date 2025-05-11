import { ref } from 'vue';
import { fetchJson } from '@/utils/fetchJson';

/**
 * composable Vue 3 permettant de faire des requêtes fetch de manière réactive et propre..
 * 
 * @param {Object|string} options - options peut être Une chaîne de caractères (URL simple)Un objet de configuration avec :url, method, data, headers, etc.
 * 
 * @param {string} options.url - Relative request URL (required)
 * @param {Object|null} [options.data=null] - Data to send (body or query string)
 * @param {string|null} [options.method=null] - HTTP method (GET, POST, etc.)
 * @param {Object} [options.headers={}] - Additional headers
 * @param {number} [options.timeout=5000] - Timeout in milliseconds
 * @param {string|null} [options.baseUrl=null] - Custom base URL for this request
 * @param {boolean} [options.immediate=true] - Fetch immediately on setup.
 * @returns {Object} Reactive refs and control functions.
 */


export function useFetchJson(options) {
/* data contient la réponse JSON du serveur.
error stocke les erreurs éventuelles.
loading indique si la requête est en cours.

 */
  const data = ref(null);
  const error = ref(null);
  const loading = ref(false);

  //regarde si options est une string , si oui, on l'utilise comme url
  const fetchOptions = typeof options === 'string' ? { url: options } : options;

  //immediate devient true sauf si explicitement mis à false.
  const immediate = fetchOptions.immediate !== false;
  let curAbort = () => {};

  function execute(dataOverride = undefined) {
    loading.value = true;
    data.value = null;
    error.value = null;

    //Si l'utilisateur donne un nouveau dataOverride, on l'applique aux options (utile dans un POST).
    const finalOptions = { ...fetchOptions };
    if (dataOverride !== undefined) finalOptions.data = dataOverride;

  /*   On appelle fetchJson() avec les options :
    Il retourne un objet contenant :
    request: une promesse de la réponse.
    abort: une fonction pour annuler la requête. */
    const { request, abort: newAbort } = fetchJson(finalOptions);
    curAbort = newAbort;

    //Si la requête réussit → data.value est mis à jour.
    request
      .then(res => data.value = res)
      .catch(err => error.value = err)
      .finally(() => {
        loading.value = false;
        curAbort = () => {};
      });
  };

  //Si immediate est true, la requête est envoyée immédiatement quand le composable est utilisé.
  if (immediate) execute();

/* data, error, loading → à utiliser dans le <template>
execute → pour relancer une requête à la demande
abort → pour annuler une requête manuellement */
  return { data, error, loading, execute, abort: () => curAbort() };
}