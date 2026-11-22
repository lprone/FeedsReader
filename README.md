# FeedsReader

A tiny, dependency-free RSS reader. Pick a feed from the dropdown and articles load without a page reload.

## Changes in this update

- **Security:** all feed output is HTML-escaped (`htmlspecialchars`), blocking XSS. Feed keys are validated against a whitelist. External links open with `rel="noopener noreferrer"`. Removed the Google Analytics snippet.
- **Reliability:** feeds are fetched server-side with cURL (timeout, redirects, HTTPS) and cached for 10 minutes, so remote servers aren't hammered on every request. Failed parses show a friendly error instead of raw PHP warnings.
- **Modern stack:** dropped jQuery and Google Analytics (no external dependencies). Vanilla JS + `fetch`. Responsive, accessible markup (`<label>`, `aria-label`, `sr-only`, `prefers-reduced-motion`-friendly transitions).
- **Docker:** PHP 8.2 (was EOL PHP 7.3), with `curl`, `xml`, `mbstring` enabled and a writable `cache/` directory.

## Development

Build and run with Docker:

```bash
docker build -t feedsreader .
docker run -it --rm -p 8080:80 feedsreader
```

Then open `http://localhost:8080`.

### Without Docker

Drop the files in any PHP-enabled web directory and ensure:

- `cache/` is writable by the web server (used for feed caching).
- `allow_url_fopen` is on (fallback) or cURL is available (preferred).

## Feed list

News: La Nación, iProfesional, Infobae, BBC Mundo, CNN en Español, Muy Interesante, Muy Computer, TechCrunch, FayerWayer, OLE.
Weather: Córdoba, Río Cuarto, Venado Tuerto, Junín.

## License

MIT
