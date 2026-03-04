<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>Laravel API Documentation</title>

    <link href="https://fonts.googleapis.com/css?family=Open+Sans&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset("/vendor/scribe/css/theme-default.style.css") }}" media="screen">
    <link rel="stylesheet" href="{{ asset("/vendor/scribe/css/theme-default.print.css") }}" media="print">

    <script src="https://cdn.jsdelivr.net/npm/lodash@4.17.10/lodash.min.js"></script>

    <link rel="stylesheet"
          href="https://unpkg.com/@highlightjs/cdn-assets@11.6.0/styles/obsidian.min.css">
    <script src="https://unpkg.com/@highlightjs/cdn-assets@11.6.0/highlight.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jets/0.14.1/jets.min.js"></script>

    <style id="language-style">
        /* starts out as display none and is replaced with js later  */
                    body .content .bash-example code { display: none; }
                    body .content .javascript-example code { display: none; }
            </style>

    <script>
        var tryItOutBaseUrl = "http://localhost:8000";
        var useCsrf = Boolean();
        var csrfUrl = "/sanctum/csrf-cookie";
    </script>
    <script src="{{ asset("/vendor/scribe/js/tryitout-5.8.0.js") }}"></script>

    <script src="{{ asset("/vendor/scribe/js/theme-default-5.8.0.js") }}"></script>

</head>

<body data-languages="[&quot;bash&quot;,&quot;javascript&quot;]">

<a href="#" id="nav-button">
    <span>
        MENU
        <img src="{{ asset("/vendor/scribe/images/navbar.png") }}" alt="navbar-image"/>
    </span>
</a>
<div class="tocify-wrapper">
    
            <div class="lang-selector">
                                            <button type="button" class="lang-button" data-language-name="bash">bash</button>
                                            <button type="button" class="lang-button" data-language-name="javascript">javascript</button>
                    </div>
    
    <div class="search">
        <input type="text" class="search" id="input-search" placeholder="Search">
    </div>

    <div id="toc">
                    <ul id="tocify-header-introduction" class="tocify-header">
                <li class="tocify-item level-1" data-unique="introduction">
                    <a href="#introduction">Introduction</a>
                </li>
                            </ul>
                    <ul id="tocify-header-authenticating-requests" class="tocify-header">
                <li class="tocify-item level-1" data-unique="authenticating-requests">
                    <a href="#authenticating-requests">Authenticating requests</a>
                </li>
                            </ul>
                    <ul id="tocify-header-api-keys" class="tocify-header">
                <li class="tocify-item level-1" data-unique="api-keys">
                    <a href="#api-keys">API Keys</a>
                </li>
                                    <ul id="tocify-subheader-api-keys" class="tocify-subheader">
                                                    <li class="tocify-item level-2" data-unique="api-keys-GETapi-v1-keys">
                                <a href="#api-keys-GETapi-v1-keys">List API keys with optional project filtering.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="api-keys-POSTapi-v1-keys">
                                <a href="#api-keys-POSTapi-v1-keys">Create a new API key.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="api-keys-POSTapi-v1-keys--apiKey_id--rotate">
                                <a href="#api-keys-POSTapi-v1-keys--apiKey_id--rotate">Rotate an API key and return the new plaintext secret.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="api-keys-POSTapi-v1-keys--apiKey_id--revoke">
                                <a href="#api-keys-POSTapi-v1-keys--apiKey_id--revoke">Revoke an API key.</a>
                            </li>
                                                                        </ul>
                            </ul>
                    <ul id="tocify-header-analytics" class="tocify-header">
                <li class="tocify-item level-1" data-unique="analytics">
                    <a href="#analytics">Analytics</a>
                </li>
                                    <ul id="tocify-subheader-analytics" class="tocify-subheader">
                                                    <li class="tocify-item level-2" data-unique="analytics-GETapi-v1-analytics-overview">
                                <a href="#analytics-GETapi-v1-analytics-overview">Get overview metrics for a date window.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="analytics-GETapi-v1-analytics-timeseries">
                                <a href="#analytics-GETapi-v1-analytics-timeseries">Get hourly usage points for charting.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="analytics-GETapi-v1-analytics-endpoints-top">
                                <a href="#analytics-GETapi-v1-analytics-endpoints-top">Get top endpoints by request volume.</a>
                            </li>
                                                                        </ul>
                            </ul>
                    <ul id="tocify-header-gateway" class="tocify-header">
                <li class="tocify-item level-1" data-unique="gateway">
                    <a href="#gateway">Gateway</a>
                </li>
                                    <ul id="tocify-subheader-gateway" class="tocify-subheader">
                                                    <li class="tocify-item level-2" data-unique="gateway-GETapi-g--project_slug---path--">
                                <a href="#gateway-GETapi-g--project_slug---path--">Proxy a gateway request to the project's upstream API.</a>
                            </li>
                                                                        </ul>
                            </ul>
                    <ul id="tocify-header-policies" class="tocify-header">
                <li class="tocify-item level-1" data-unique="policies">
                    <a href="#policies">Policies</a>
                </li>
                                    <ul id="tocify-subheader-policies" class="tocify-subheader">
                                                    <li class="tocify-item level-2" data-unique="policies-GETapi-v1-policies">
                                <a href="#policies-GETapi-v1-policies">List available rate limit policies.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="policies-POSTapi-v1-policies">
                                <a href="#policies-POSTapi-v1-policies">Create a new rate limit policy.</a>
                            </li>
                                                                        </ul>
                            </ul>
                    <ul id="tocify-header-projects" class="tocify-header">
                <li class="tocify-item level-1" data-unique="projects">
                    <a href="#projects">Projects</a>
                </li>
                                    <ul id="tocify-subheader-projects" class="tocify-subheader">
                                                    <li class="tocify-item level-2" data-unique="projects-GETapi-v1-projects">
                                <a href="#projects-GETapi-v1-projects">List projects for the admin dashboard.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="projects-POSTapi-v1-projects">
                                <a href="#projects-POSTapi-v1-projects">Create a new upstream project.</a>
                            </li>
                                                                        </ul>
                            </ul>
            </div>

    <ul class="toc-footer" id="toc-footer">
                    <li style="padding-bottom: 5px;"><a href="{{ route("scribe.postman") }}">View Postman collection</a></li>
                            <li style="padding-bottom: 5px;"><a href="{{ route("scribe.openapi") }}">View OpenAPI spec</a></li>
                <li><a href="http://github.com/knuckleswtf/scribe">Documentation powered by Scribe ✍</a></li>
    </ul>

    <ul class="toc-footer" id="last-updated">
        <li>Last updated: March 4, 2026</li>
    </ul>
</div>

<div class="page-wrapper">
    <div class="dark-box"></div>
    <div class="content">
        <h1 id="introduction">Introduction</h1>
<p>Flowgate is an API gateway for key management, rate limiting, request telemetry, and analytics.</p>
<aside>
    <strong>Base URL</strong>: <code>http://localhost:8000</code>
</aside>
<pre><code>Use these endpoints to manage projects, issue API keys, enforce gateway rate limits, and query analytics.

Authentication model:
- Management endpoints (`/api/v1/*`) require `X-Admin-Token`.
- Gateway endpoint (`/api/g/*`) requires `X-Api-Key` (or Bearer token).</code></pre>

        <h1 id="authenticating-requests">Authenticating requests</h1>
<p>This API is not authenticated.</p>

        <h1 id="api-keys">API Keys</h1>

    

                                <h2 id="api-keys-GETapi-v1-keys">List API keys with optional project filtering.</h2>

<p>
</p>



<span id="example-requests-GETapi-v1-keys">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost:8000/api/v1/keys?project_id=1&amp;per_page=20" \
    --header "X-Admin-Token: string required Admin token for Flowgate management endpoints." \
    --header "X-Request-Id: string Optional correlation ID. If omitted, one is generated." \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost:8000/api/v1/keys"
);

const params = {
    "project_id": "1",
    "per_page": "20",
};
Object.keys(params)
    .forEach(key =&gt; url.searchParams.append(key, params[key]));

const headers = {
    "X-Admin-Token": "string required Admin token for Flowgate management endpoints.",
    "X-Request-Id": "string Optional correlation ID. If omitted, one is generated.",
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-v1-keys">
    </span>
<span id="execution-results-GETapi-v1-keys" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-v1-keys"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-v1-keys"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-v1-keys" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-v1-keys">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-v1-keys" data-method="GET"
      data-path="api/v1/keys"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-v1-keys', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-v1-keys"
                    onclick="tryItOut('GETapi-v1-keys');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-v1-keys"
                    onclick="cancelTryOut('GETapi-v1-keys');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-v1-keys"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/v1/keys</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>X-Admin-Token</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="X-Admin-Token"                data-endpoint="GETapi-v1-keys"
               value="string required Admin token for Flowgate management endpoints."
               data-component="header">
    <br>
<p>Example: <code>string required Admin token for Flowgate management endpoints.</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>X-Request-Id</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="X-Request-Id"                data-endpoint="GETapi-v1-keys"
               value="string Optional correlation ID. If omitted, one is generated."
               data-component="header">
    <br>
<p>Example: <code>string Optional correlation ID. If omitted, one is generated.</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-v1-keys"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-v1-keys"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Query Parameters</b></h4>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>project_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="project_id"                data-endpoint="GETapi-v1-keys"
               value="1"
               data-component="query">
    <br>
<p>Filter keys by project ID. Example: <code>1</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>per_page</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="per_page"                data-endpoint="GETapi-v1-keys"
               value="20"
               data-component="query">
    <br>
<p>Number of records per page (max 100). Example: <code>20</code></p>
            </div>
                </form>

                    <h2 id="api-keys-POSTapi-v1-keys">Create a new API key.</h2>

<p>
</p>



<span id="example-requests-POSTapi-v1-keys">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://localhost:8000/api/v1/keys" \
    --header "X-Admin-Token: string required Admin token for Flowgate management endpoints." \
    --header "X-Request-Id: string Optional correlation ID. If omitted, one is generated." \
    --header "Idempotency-Key: string Optional idempotency key for safe retries." \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"project_id\": 1,
    \"rate_limit_policy_id\": 1,
    \"name\": \"Server Key\",
    \"expires_at\": \"2026-12-31 23:59:59\"
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost:8000/api/v1/keys"
);

const headers = {
    "X-Admin-Token": "string required Admin token for Flowgate management endpoints.",
    "X-Request-Id": "string Optional correlation ID. If omitted, one is generated.",
    "Idempotency-Key": "string Optional idempotency key for safe retries.",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "project_id": 1,
    "rate_limit_policy_id": 1,
    "name": "Server Key",
    "expires_at": "2026-12-31 23:59:59"
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-v1-keys">
</span>
<span id="execution-results-POSTapi-v1-keys" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-v1-keys"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-v1-keys"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-v1-keys" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-v1-keys">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-v1-keys" data-method="POST"
      data-path="api/v1/keys"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-v1-keys', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-v1-keys"
                    onclick="tryItOut('POSTapi-v1-keys');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-v1-keys"
                    onclick="cancelTryOut('POSTapi-v1-keys');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-v1-keys"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/v1/keys</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>X-Admin-Token</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="X-Admin-Token"                data-endpoint="POSTapi-v1-keys"
               value="string required Admin token for Flowgate management endpoints."
               data-component="header">
    <br>
<p>Example: <code>string required Admin token for Flowgate management endpoints.</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>X-Request-Id</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="X-Request-Id"                data-endpoint="POSTapi-v1-keys"
               value="string Optional correlation ID. If omitted, one is generated."
               data-component="header">
    <br>
<p>Example: <code>string Optional correlation ID. If omitted, one is generated.</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Idempotency-Key</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Idempotency-Key"                data-endpoint="POSTapi-v1-keys"
               value="string Optional idempotency key for safe retries."
               data-component="header">
    <br>
<p>Example: <code>string Optional idempotency key for safe retries.</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-v1-keys"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-v1-keys"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>project_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="project_id"                data-endpoint="POSTapi-v1-keys"
               value="1"
               data-component="body">
    <br>
<p>Owning project ID. Example: <code>1</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>rate_limit_policy_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="rate_limit_policy_id"                data-endpoint="POSTapi-v1-keys"
               value="1"
               data-component="body">
    <br>
<p>Optional rate limit policy ID. Example: <code>1</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>name</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="name"                data-endpoint="POSTapi-v1-keys"
               value="Server Key"
               data-component="body">
    <br>
<p>Friendly key label. Example: <code>Server Key</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>expires_at</code></b>&nbsp;&nbsp;
<small>datetime</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="expires_at"                data-endpoint="POSTapi-v1-keys"
               value="2026-12-31 23:59:59"
               data-component="body">
    <br>
<p>Optional expiration timestamp. Example: <code>2026-12-31 23:59:59</code></p>
        </div>
        </form>

                    <h2 id="api-keys-POSTapi-v1-keys--apiKey_id--rotate">Rotate an API key and return the new plaintext secret.</h2>

<p>
</p>



<span id="example-requests-POSTapi-v1-keys--apiKey_id--rotate">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://localhost:8000/api/v1/keys/16/rotate" \
    --header "X-Admin-Token: string required Admin token for Flowgate management endpoints." \
    --header "X-Request-Id: string Optional correlation ID. If omitted, one is generated." \
    --header "Idempotency-Key: string Optional idempotency key for safe retries." \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost:8000/api/v1/keys/16/rotate"
);

const headers = {
    "X-Admin-Token": "string required Admin token for Flowgate management endpoints.",
    "X-Request-Id": "string Optional correlation ID. If omitted, one is generated.",
    "Idempotency-Key": "string Optional idempotency key for safe retries.",
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "POST",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-v1-keys--apiKey_id--rotate">
</span>
<span id="execution-results-POSTapi-v1-keys--apiKey_id--rotate" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-v1-keys--apiKey_id--rotate"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-v1-keys--apiKey_id--rotate"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-v1-keys--apiKey_id--rotate" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-v1-keys--apiKey_id--rotate">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-v1-keys--apiKey_id--rotate" data-method="POST"
      data-path="api/v1/keys/{apiKey_id}/rotate"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-v1-keys--apiKey_id--rotate', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-v1-keys--apiKey_id--rotate"
                    onclick="tryItOut('POSTapi-v1-keys--apiKey_id--rotate');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-v1-keys--apiKey_id--rotate"
                    onclick="cancelTryOut('POSTapi-v1-keys--apiKey_id--rotate');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-v1-keys--apiKey_id--rotate"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/v1/keys/{apiKey_id}/rotate</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>X-Admin-Token</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="X-Admin-Token"                data-endpoint="POSTapi-v1-keys--apiKey_id--rotate"
               value="string required Admin token for Flowgate management endpoints."
               data-component="header">
    <br>
<p>Example: <code>string required Admin token for Flowgate management endpoints.</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>X-Request-Id</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="X-Request-Id"                data-endpoint="POSTapi-v1-keys--apiKey_id--rotate"
               value="string Optional correlation ID. If omitted, one is generated."
               data-component="header">
    <br>
<p>Example: <code>string Optional correlation ID. If omitted, one is generated.</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Idempotency-Key</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Idempotency-Key"                data-endpoint="POSTapi-v1-keys--apiKey_id--rotate"
               value="string Optional idempotency key for safe retries."
               data-component="header">
    <br>
<p>Example: <code>string Optional idempotency key for safe retries.</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-v1-keys--apiKey_id--rotate"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-v1-keys--apiKey_id--rotate"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>apiKey_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="apiKey_id"                data-endpoint="POSTapi-v1-keys--apiKey_id--rotate"
               value="16"
               data-component="url">
    <br>
<p>The ID of the apiKey. Example: <code>16</code></p>
            </div>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>apiKey</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="apiKey"                data-endpoint="POSTapi-v1-keys--apiKey_id--rotate"
               value="1"
               data-component="url">
    <br>
<p>API key ID. Example: <code>1</code></p>
            </div>
                    </form>

                    <h2 id="api-keys-POSTapi-v1-keys--apiKey_id--revoke">Revoke an API key.</h2>

<p>
</p>



<span id="example-requests-POSTapi-v1-keys--apiKey_id--revoke">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://localhost:8000/api/v1/keys/16/revoke" \
    --header "X-Admin-Token: string required Admin token for Flowgate management endpoints." \
    --header "X-Request-Id: string Optional correlation ID. If omitted, one is generated." \
    --header "Idempotency-Key: string Optional idempotency key for safe retries." \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost:8000/api/v1/keys/16/revoke"
);

const headers = {
    "X-Admin-Token": "string required Admin token for Flowgate management endpoints.",
    "X-Request-Id": "string Optional correlation ID. If omitted, one is generated.",
    "Idempotency-Key": "string Optional idempotency key for safe retries.",
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "POST",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-v1-keys--apiKey_id--revoke">
</span>
<span id="execution-results-POSTapi-v1-keys--apiKey_id--revoke" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-v1-keys--apiKey_id--revoke"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-v1-keys--apiKey_id--revoke"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-v1-keys--apiKey_id--revoke" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-v1-keys--apiKey_id--revoke">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-v1-keys--apiKey_id--revoke" data-method="POST"
      data-path="api/v1/keys/{apiKey_id}/revoke"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-v1-keys--apiKey_id--revoke', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-v1-keys--apiKey_id--revoke"
                    onclick="tryItOut('POSTapi-v1-keys--apiKey_id--revoke');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-v1-keys--apiKey_id--revoke"
                    onclick="cancelTryOut('POSTapi-v1-keys--apiKey_id--revoke');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-v1-keys--apiKey_id--revoke"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/v1/keys/{apiKey_id}/revoke</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>X-Admin-Token</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="X-Admin-Token"                data-endpoint="POSTapi-v1-keys--apiKey_id--revoke"
               value="string required Admin token for Flowgate management endpoints."
               data-component="header">
    <br>
<p>Example: <code>string required Admin token for Flowgate management endpoints.</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>X-Request-Id</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="X-Request-Id"                data-endpoint="POSTapi-v1-keys--apiKey_id--revoke"
               value="string Optional correlation ID. If omitted, one is generated."
               data-component="header">
    <br>
<p>Example: <code>string Optional correlation ID. If omitted, one is generated.</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Idempotency-Key</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Idempotency-Key"                data-endpoint="POSTapi-v1-keys--apiKey_id--revoke"
               value="string Optional idempotency key for safe retries."
               data-component="header">
    <br>
<p>Example: <code>string Optional idempotency key for safe retries.</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-v1-keys--apiKey_id--revoke"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-v1-keys--apiKey_id--revoke"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>apiKey_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="apiKey_id"                data-endpoint="POSTapi-v1-keys--apiKey_id--revoke"
               value="16"
               data-component="url">
    <br>
<p>The ID of the apiKey. Example: <code>16</code></p>
            </div>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>apiKey</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="apiKey"                data-endpoint="POSTapi-v1-keys--apiKey_id--revoke"
               value="1"
               data-component="url">
    <br>
<p>API key ID. Example: <code>1</code></p>
            </div>
                    </form>

                <h1 id="analytics">Analytics</h1>

    

                                <h2 id="analytics-GETapi-v1-analytics-overview">Get overview metrics for a date window.</h2>

<p>
</p>



<span id="example-requests-GETapi-v1-analytics-overview">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost:8000/api/v1/analytics/overview?from=2026-03-03+00%3A00%3A00&amp;to=2026-03-04+00%3A00%3A00&amp;project_id=1" \
    --header "X-Admin-Token: string required Admin token for Flowgate management endpoints." \
    --header "X-Request-Id: string Optional correlation ID. If omitted, one is generated." \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost:8000/api/v1/analytics/overview"
);

const params = {
    "from": "2026-03-03 00:00:00",
    "to": "2026-03-04 00:00:00",
    "project_id": "1",
};
Object.keys(params)
    .forEach(key =&gt; url.searchParams.append(key, params[key]));

const headers = {
    "X-Admin-Token": "string required Admin token for Flowgate management endpoints.",
    "X-Request-Id": "string Optional correlation ID. If omitted, one is generated.",
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-v1-analytics-overview">
    </span>
<span id="execution-results-GETapi-v1-analytics-overview" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-v1-analytics-overview"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-v1-analytics-overview"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-v1-analytics-overview" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-v1-analytics-overview">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-v1-analytics-overview" data-method="GET"
      data-path="api/v1/analytics/overview"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-v1-analytics-overview', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-v1-analytics-overview"
                    onclick="tryItOut('GETapi-v1-analytics-overview');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-v1-analytics-overview"
                    onclick="cancelTryOut('GETapi-v1-analytics-overview');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-v1-analytics-overview"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/v1/analytics/overview</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>X-Admin-Token</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="X-Admin-Token"                data-endpoint="GETapi-v1-analytics-overview"
               value="string required Admin token for Flowgate management endpoints."
               data-component="header">
    <br>
<p>Example: <code>string required Admin token for Flowgate management endpoints.</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>X-Request-Id</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="X-Request-Id"                data-endpoint="GETapi-v1-analytics-overview"
               value="string Optional correlation ID. If omitted, one is generated."
               data-component="header">
    <br>
<p>Example: <code>string Optional correlation ID. If omitted, one is generated.</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-v1-analytics-overview"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-v1-analytics-overview"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Query Parameters</b></h4>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>from</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="from"                data-endpoint="GETapi-v1-analytics-overview"
               value="2026-03-03 00:00:00"
               data-component="query">
    <br>
<p>datetime Inclusive window start. Example: <code>2026-03-03 00:00:00</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>to</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="to"                data-endpoint="GETapi-v1-analytics-overview"
               value="2026-03-04 00:00:00"
               data-component="query">
    <br>
<p>datetime Inclusive window end. Example: <code>2026-03-04 00:00:00</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>project_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="project_id"                data-endpoint="GETapi-v1-analytics-overview"
               value="1"
               data-component="query">
    <br>
<p>Filter by project ID. Example: <code>1</code></p>
            </div>
                </form>

                    <h2 id="analytics-GETapi-v1-analytics-timeseries">Get hourly usage points for charting.</h2>

<p>
</p>



<span id="example-requests-GETapi-v1-analytics-timeseries">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost:8000/api/v1/analytics/timeseries?from=2026-03-03+00%3A00%3A00&amp;to=2026-03-04+00%3A00%3A00&amp;project_id=1" \
    --header "X-Admin-Token: string required Admin token for Flowgate management endpoints." \
    --header "X-Request-Id: string Optional correlation ID. If omitted, one is generated." \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost:8000/api/v1/analytics/timeseries"
);

const params = {
    "from": "2026-03-03 00:00:00",
    "to": "2026-03-04 00:00:00",
    "project_id": "1",
};
Object.keys(params)
    .forEach(key =&gt; url.searchParams.append(key, params[key]));

const headers = {
    "X-Admin-Token": "string required Admin token for Flowgate management endpoints.",
    "X-Request-Id": "string Optional correlation ID. If omitted, one is generated.",
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-v1-analytics-timeseries">
    </span>
<span id="execution-results-GETapi-v1-analytics-timeseries" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-v1-analytics-timeseries"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-v1-analytics-timeseries"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-v1-analytics-timeseries" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-v1-analytics-timeseries">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-v1-analytics-timeseries" data-method="GET"
      data-path="api/v1/analytics/timeseries"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-v1-analytics-timeseries', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-v1-analytics-timeseries"
                    onclick="tryItOut('GETapi-v1-analytics-timeseries');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-v1-analytics-timeseries"
                    onclick="cancelTryOut('GETapi-v1-analytics-timeseries');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-v1-analytics-timeseries"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/v1/analytics/timeseries</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>X-Admin-Token</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="X-Admin-Token"                data-endpoint="GETapi-v1-analytics-timeseries"
               value="string required Admin token for Flowgate management endpoints."
               data-component="header">
    <br>
<p>Example: <code>string required Admin token for Flowgate management endpoints.</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>X-Request-Id</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="X-Request-Id"                data-endpoint="GETapi-v1-analytics-timeseries"
               value="string Optional correlation ID. If omitted, one is generated."
               data-component="header">
    <br>
<p>Example: <code>string Optional correlation ID. If omitted, one is generated.</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-v1-analytics-timeseries"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-v1-analytics-timeseries"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Query Parameters</b></h4>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>from</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="from"                data-endpoint="GETapi-v1-analytics-timeseries"
               value="2026-03-03 00:00:00"
               data-component="query">
    <br>
<p>datetime Inclusive window start. Example: <code>2026-03-03 00:00:00</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>to</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="to"                data-endpoint="GETapi-v1-analytics-timeseries"
               value="2026-03-04 00:00:00"
               data-component="query">
    <br>
<p>datetime Inclusive window end. Example: <code>2026-03-04 00:00:00</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>project_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="project_id"                data-endpoint="GETapi-v1-analytics-timeseries"
               value="1"
               data-component="query">
    <br>
<p>Filter by project ID. Example: <code>1</code></p>
            </div>
                </form>

                    <h2 id="analytics-GETapi-v1-analytics-endpoints-top">Get top endpoints by request volume.</h2>

<p>
</p>



<span id="example-requests-GETapi-v1-analytics-endpoints-top">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost:8000/api/v1/analytics/endpoints/top?from=2026-03-03+00%3A00%3A00&amp;to=2026-03-04+00%3A00%3A00&amp;project_id=1&amp;limit=10" \
    --header "X-Admin-Token: string required Admin token for Flowgate management endpoints." \
    --header "X-Request-Id: string Optional correlation ID. If omitted, one is generated." \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost:8000/api/v1/analytics/endpoints/top"
);

const params = {
    "from": "2026-03-03 00:00:00",
    "to": "2026-03-04 00:00:00",
    "project_id": "1",
    "limit": "10",
};
Object.keys(params)
    .forEach(key =&gt; url.searchParams.append(key, params[key]));

const headers = {
    "X-Admin-Token": "string required Admin token for Flowgate management endpoints.",
    "X-Request-Id": "string Optional correlation ID. If omitted, one is generated.",
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-v1-analytics-endpoints-top">
    </span>
<span id="execution-results-GETapi-v1-analytics-endpoints-top" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-v1-analytics-endpoints-top"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-v1-analytics-endpoints-top"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-v1-analytics-endpoints-top" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-v1-analytics-endpoints-top">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-v1-analytics-endpoints-top" data-method="GET"
      data-path="api/v1/analytics/endpoints/top"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-v1-analytics-endpoints-top', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-v1-analytics-endpoints-top"
                    onclick="tryItOut('GETapi-v1-analytics-endpoints-top');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-v1-analytics-endpoints-top"
                    onclick="cancelTryOut('GETapi-v1-analytics-endpoints-top');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-v1-analytics-endpoints-top"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/v1/analytics/endpoints/top</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>X-Admin-Token</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="X-Admin-Token"                data-endpoint="GETapi-v1-analytics-endpoints-top"
               value="string required Admin token for Flowgate management endpoints."
               data-component="header">
    <br>
<p>Example: <code>string required Admin token for Flowgate management endpoints.</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>X-Request-Id</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="X-Request-Id"                data-endpoint="GETapi-v1-analytics-endpoints-top"
               value="string Optional correlation ID. If omitted, one is generated."
               data-component="header">
    <br>
<p>Example: <code>string Optional correlation ID. If omitted, one is generated.</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-v1-analytics-endpoints-top"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-v1-analytics-endpoints-top"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Query Parameters</b></h4>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>from</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="from"                data-endpoint="GETapi-v1-analytics-endpoints-top"
               value="2026-03-03 00:00:00"
               data-component="query">
    <br>
<p>datetime Inclusive window start. Example: <code>2026-03-03 00:00:00</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>to</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="to"                data-endpoint="GETapi-v1-analytics-endpoints-top"
               value="2026-03-04 00:00:00"
               data-component="query">
    <br>
<p>datetime Inclusive window end. Example: <code>2026-03-04 00:00:00</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>project_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="project_id"                data-endpoint="GETapi-v1-analytics-endpoints-top"
               value="1"
               data-component="query">
    <br>
<p>Filter by project ID. Example: <code>1</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>limit</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="limit"                data-endpoint="GETapi-v1-analytics-endpoints-top"
               value="10"
               data-component="query">
    <br>
<p>Number of endpoints to return. Example: <code>10</code></p>
            </div>
                </form>

                <h1 id="gateway">Gateway</h1>

    

                                <h2 id="gateway-GETapi-g--project_slug---path--">Proxy a gateway request to the project&#039;s upstream API.</h2>

<p>
</p>



<span id="example-requests-GETapi-g--project_slug---path--">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost:8000/api/g/architecto/customers" \
    --header "X-Api-Key: string required API key used for gateway authentication." \
    --header "X-Request-Id: string Optional correlation ID. If omitted, one is generated." \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost:8000/api/g/architecto/customers"
);

const headers = {
    "X-Api-Key": "string required API key used for gateway authentication.",
    "X-Request-Id": "string Optional correlation ID. If omitted, one is generated.",
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-g--project_slug---path--">
    </span>
<span id="execution-results-GETapi-g--project_slug---path--" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-g--project_slug---path--"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-g--project_slug---path--"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-g--project_slug---path--" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-g--project_slug---path--">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-g--project_slug---path--" data-method="GET"
      data-path="api/g/{project_slug}/{path?}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-g--project_slug---path--', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-g--project_slug---path--"
                    onclick="tryItOut('GETapi-g--project_slug---path--');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-g--project_slug---path--"
                    onclick="cancelTryOut('GETapi-g--project_slug---path--');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-g--project_slug---path--"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/g/{project_slug}/{path?}</code></b>
        </p>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/g/{project_slug}/{path?}</code></b>
        </p>
            <p>
            <small class="badge badge-darkblue">PUT</small>
            <b><code>api/g/{project_slug}/{path?}</code></b>
        </p>
            <p>
            <small class="badge badge-purple">PATCH</small>
            <b><code>api/g/{project_slug}/{path?}</code></b>
        </p>
            <p>
            <small class="badge badge-red">DELETE</small>
            <b><code>api/g/{project_slug}/{path?}</code></b>
        </p>
            <p>
            <small class="badge badge-grey">OPTIONS</small>
            <b><code>api/g/{project_slug}/{path?}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>X-Api-Key</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="X-Api-Key"                data-endpoint="GETapi-g--project_slug---path--"
               value="string required API key used for gateway authentication."
               data-component="header">
    <br>
<p>Example: <code>string required API key used for gateway authentication.</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>X-Request-Id</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="X-Request-Id"                data-endpoint="GETapi-g--project_slug---path--"
               value="string Optional correlation ID. If omitted, one is generated."
               data-component="header">
    <br>
<p>Example: <code>string Optional correlation ID. If omitted, one is generated.</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-g--project_slug---path--"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-g--project_slug---path--"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>project_slug</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="project_slug"                data-endpoint="GETapi-g--project_slug---path--"
               value="architecto"
               data-component="url">
    <br>
<p>The slug of the project. Example: <code>architecto</code></p>
            </div>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>path</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="path"                data-endpoint="GETapi-g--project_slug---path--"
               value="customers"
               data-component="url">
    <br>
<p>Optional upstream path after project slug. Example: <code>customers</code></p>
            </div>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>project</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="project"                data-endpoint="GETapi-g--project_slug---path--"
               value="primary-api"
               data-component="url">
    <br>
<p>Project slug. Example: <code>primary-api</code></p>
            </div>
                    </form>

                <h1 id="policies">Policies</h1>

    

                                <h2 id="policies-GETapi-v1-policies">List available rate limit policies.</h2>

<p>
</p>



<span id="example-requests-GETapi-v1-policies">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost:8000/api/v1/policies?page=1&amp;per_page=20" \
    --header "X-Admin-Token: string required Admin token for Flowgate management endpoints." \
    --header "X-Request-Id: string Optional correlation ID. If omitted, one is generated." \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost:8000/api/v1/policies"
);

const params = {
    "page": "1",
    "per_page": "20",
};
Object.keys(params)
    .forEach(key =&gt; url.searchParams.append(key, params[key]));

const headers = {
    "X-Admin-Token": "string required Admin token for Flowgate management endpoints.",
    "X-Request-Id": "string Optional correlation ID. If omitted, one is generated.",
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-v1-policies">
    </span>
<span id="execution-results-GETapi-v1-policies" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-v1-policies"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-v1-policies"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-v1-policies" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-v1-policies">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-v1-policies" data-method="GET"
      data-path="api/v1/policies"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-v1-policies', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-v1-policies"
                    onclick="tryItOut('GETapi-v1-policies');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-v1-policies"
                    onclick="cancelTryOut('GETapi-v1-policies');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-v1-policies"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/v1/policies</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>X-Admin-Token</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="X-Admin-Token"                data-endpoint="GETapi-v1-policies"
               value="string required Admin token for Flowgate management endpoints."
               data-component="header">
    <br>
<p>Example: <code>string required Admin token for Flowgate management endpoints.</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>X-Request-Id</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="X-Request-Id"                data-endpoint="GETapi-v1-policies"
               value="string Optional correlation ID. If omitted, one is generated."
               data-component="header">
    <br>
<p>Example: <code>string Optional correlation ID. If omitted, one is generated.</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-v1-policies"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-v1-policies"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Query Parameters</b></h4>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>page</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="page"                data-endpoint="GETapi-v1-policies"
               value="1"
               data-component="query">
    <br>
<p>Page number. Example: <code>1</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>per_page</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="per_page"                data-endpoint="GETapi-v1-policies"
               value="20"
               data-component="query">
    <br>
<p>Number of records per page (max 100). Example: <code>20</code></p>
            </div>
                </form>

                    <h2 id="policies-POSTapi-v1-policies">Create a new rate limit policy.</h2>

<p>
</p>



<span id="example-requests-POSTapi-v1-policies">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://localhost:8000/api/v1/policies" \
    --header "X-Admin-Token: string required Admin token for Flowgate management endpoints." \
    --header "X-Request-Id: string Optional correlation ID. If omitted, one is generated." \
    --header "Idempotency-Key: string Optional idempotency key for safe retries." \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"project_id\": 1,
    \"name\": \"Starter\",
    \"requests_per_minute\": 60,
    \"requests_per_hour\": 1000,
    \"burst_limit\": 120,
    \"is_active\": true
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost:8000/api/v1/policies"
);

const headers = {
    "X-Admin-Token": "string required Admin token for Flowgate management endpoints.",
    "X-Request-Id": "string Optional correlation ID. If omitted, one is generated.",
    "Idempotency-Key": "string Optional idempotency key for safe retries.",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "project_id": 1,
    "name": "Starter",
    "requests_per_minute": 60,
    "requests_per_hour": 1000,
    "burst_limit": 120,
    "is_active": true
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-v1-policies">
</span>
<span id="execution-results-POSTapi-v1-policies" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-v1-policies"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-v1-policies"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-v1-policies" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-v1-policies">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-v1-policies" data-method="POST"
      data-path="api/v1/policies"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-v1-policies', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-v1-policies"
                    onclick="tryItOut('POSTapi-v1-policies');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-v1-policies"
                    onclick="cancelTryOut('POSTapi-v1-policies');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-v1-policies"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/v1/policies</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>X-Admin-Token</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="X-Admin-Token"                data-endpoint="POSTapi-v1-policies"
               value="string required Admin token for Flowgate management endpoints."
               data-component="header">
    <br>
<p>Example: <code>string required Admin token for Flowgate management endpoints.</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>X-Request-Id</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="X-Request-Id"                data-endpoint="POSTapi-v1-policies"
               value="string Optional correlation ID. If omitted, one is generated."
               data-component="header">
    <br>
<p>Example: <code>string Optional correlation ID. If omitted, one is generated.</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Idempotency-Key</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Idempotency-Key"                data-endpoint="POSTapi-v1-policies"
               value="string Optional idempotency key for safe retries."
               data-component="header">
    <br>
<p>Example: <code>string Optional idempotency key for safe retries.</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-v1-policies"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-v1-policies"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>project_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="project_id"                data-endpoint="POSTapi-v1-policies"
               value="1"
               data-component="body">
    <br>
<p>Optional project scope for this policy. Example: <code>1</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>name</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="name"                data-endpoint="POSTapi-v1-policies"
               value="Starter"
               data-component="body">
    <br>
<p>Policy name. Example: <code>Starter</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>requests_per_minute</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="requests_per_minute"                data-endpoint="POSTapi-v1-policies"
               value="60"
               data-component="body">
    <br>
<p>Allowed requests each minute. Example: <code>60</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>requests_per_hour</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="requests_per_hour"                data-endpoint="POSTapi-v1-policies"
               value="1000"
               data-component="body">
    <br>
<p>Allowed requests each hour. Example: <code>1000</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>burst_limit</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="burst_limit"                data-endpoint="POSTapi-v1-policies"
               value="120"
               data-component="body">
    <br>
<p>Short burst allowance. Example: <code>120</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>is_active</code></b>&nbsp;&nbsp;
<small>boolean</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <label data-endpoint="POSTapi-v1-policies" style="display: none">
            <input type="radio" name="is_active"
                   value="true"
                   data-endpoint="POSTapi-v1-policies"
                   data-component="body"             >
            <code>true</code>
        </label>
        <label data-endpoint="POSTapi-v1-policies" style="display: none">
            <input type="radio" name="is_active"
                   value="false"
                   data-endpoint="POSTapi-v1-policies"
                   data-component="body"             >
            <code>false</code>
        </label>
    <br>
<p>Policy active flag. Example: <code>true</code></p>
        </div>
        </form>

                <h1 id="projects">Projects</h1>

    

                                <h2 id="projects-GETapi-v1-projects">List projects for the admin dashboard.</h2>

<p>
</p>



<span id="example-requests-GETapi-v1-projects">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost:8000/api/v1/projects?page=1&amp;per_page=20" \
    --header "X-Admin-Token: string required Admin token for Flowgate management endpoints." \
    --header "X-Request-Id: string Optional correlation ID. If omitted, one is generated." \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost:8000/api/v1/projects"
);

const params = {
    "page": "1",
    "per_page": "20",
};
Object.keys(params)
    .forEach(key =&gt; url.searchParams.append(key, params[key]));

const headers = {
    "X-Admin-Token": "string required Admin token for Flowgate management endpoints.",
    "X-Request-Id": "string Optional correlation ID. If omitted, one is generated.",
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-v1-projects">
    </span>
<span id="execution-results-GETapi-v1-projects" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-v1-projects"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-v1-projects"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-v1-projects" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-v1-projects">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-v1-projects" data-method="GET"
      data-path="api/v1/projects"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-v1-projects', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-v1-projects"
                    onclick="tryItOut('GETapi-v1-projects');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-v1-projects"
                    onclick="cancelTryOut('GETapi-v1-projects');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-v1-projects"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/v1/projects</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>X-Admin-Token</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="X-Admin-Token"                data-endpoint="GETapi-v1-projects"
               value="string required Admin token for Flowgate management endpoints."
               data-component="header">
    <br>
<p>Example: <code>string required Admin token for Flowgate management endpoints.</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>X-Request-Id</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="X-Request-Id"                data-endpoint="GETapi-v1-projects"
               value="string Optional correlation ID. If omitted, one is generated."
               data-component="header">
    <br>
<p>Example: <code>string Optional correlation ID. If omitted, one is generated.</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-v1-projects"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-v1-projects"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Query Parameters</b></h4>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>page</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="page"                data-endpoint="GETapi-v1-projects"
               value="1"
               data-component="query">
    <br>
<p>Page number. Example: <code>1</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>per_page</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="per_page"                data-endpoint="GETapi-v1-projects"
               value="20"
               data-component="query">
    <br>
<p>Number of records per page (max 100). Example: <code>20</code></p>
            </div>
                </form>

                    <h2 id="projects-POSTapi-v1-projects">Create a new upstream project.</h2>

<p>
</p>



<span id="example-requests-POSTapi-v1-projects">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://localhost:8000/api/v1/projects" \
    --header "X-Admin-Token: string required Admin token for Flowgate management endpoints." \
    --header "X-Request-Id: string Optional correlation ID. If omitted, one is generated." \
    --header "Idempotency-Key: string Optional idempotency key for safe retries." \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"name\": \"Primary API\",
    \"slug\": \"primary-api\",
    \"upstream_base_url\": \"https:\\/\\/api.example.com\",
    \"is_active\": true
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost:8000/api/v1/projects"
);

const headers = {
    "X-Admin-Token": "string required Admin token for Flowgate management endpoints.",
    "X-Request-Id": "string Optional correlation ID. If omitted, one is generated.",
    "Idempotency-Key": "string Optional idempotency key for safe retries.",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "name": "Primary API",
    "slug": "primary-api",
    "upstream_base_url": "https:\/\/api.example.com",
    "is_active": true
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-v1-projects">
</span>
<span id="execution-results-POSTapi-v1-projects" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-v1-projects"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-v1-projects"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-v1-projects" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-v1-projects">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-v1-projects" data-method="POST"
      data-path="api/v1/projects"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-v1-projects', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-v1-projects"
                    onclick="tryItOut('POSTapi-v1-projects');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-v1-projects"
                    onclick="cancelTryOut('POSTapi-v1-projects');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-v1-projects"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/v1/projects</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>X-Admin-Token</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="X-Admin-Token"                data-endpoint="POSTapi-v1-projects"
               value="string required Admin token for Flowgate management endpoints."
               data-component="header">
    <br>
<p>Example: <code>string required Admin token for Flowgate management endpoints.</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>X-Request-Id</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="X-Request-Id"                data-endpoint="POSTapi-v1-projects"
               value="string Optional correlation ID. If omitted, one is generated."
               data-component="header">
    <br>
<p>Example: <code>string Optional correlation ID. If omitted, one is generated.</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Idempotency-Key</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Idempotency-Key"                data-endpoint="POSTapi-v1-projects"
               value="string Optional idempotency key for safe retries."
               data-component="header">
    <br>
<p>Example: <code>string Optional idempotency key for safe retries.</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-v1-projects"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-v1-projects"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>name</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="name"                data-endpoint="POSTapi-v1-projects"
               value="Primary API"
               data-component="body">
    <br>
<p>Human-readable project name. Example: <code>Primary API</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>slug</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="slug"                data-endpoint="POSTapi-v1-projects"
               value="primary-api"
               data-component="body">
    <br>
<p>URL-safe project identifier. Example: <code>primary-api</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>upstream_base_url</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="upstream_base_url"                data-endpoint="POSTapi-v1-projects"
               value="https://api.example.com"
               data-component="body">
    <br>
<p>Base URL of the upstream API. Example: <code>https://api.example.com</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>is_active</code></b>&nbsp;&nbsp;
<small>boolean</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <label data-endpoint="POSTapi-v1-projects" style="display: none">
            <input type="radio" name="is_active"
                   value="true"
                   data-endpoint="POSTapi-v1-projects"
                   data-component="body"             >
            <code>true</code>
        </label>
        <label data-endpoint="POSTapi-v1-projects" style="display: none">
            <input type="radio" name="is_active"
                   value="false"
                   data-endpoint="POSTapi-v1-projects"
                   data-component="body"             >
            <code>false</code>
        </label>
    <br>
<p>Whether this project accepts gateway traffic. Example: <code>true</code></p>
        </div>
        </form>

            

        
    </div>
    <div class="dark-box">
                    <div class="lang-selector">
                                                        <button type="button" class="lang-button" data-language-name="bash">bash</button>
                                                        <button type="button" class="lang-button" data-language-name="javascript">javascript</button>
                            </div>
            </div>
</div>
</body>
</html>
