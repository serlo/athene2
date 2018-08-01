addEventListener('fetch', event => {
    event.respondWith(handleRequest(event.request))
})

async function handleRequest(request) {
    return (
        (await handleSemanticAssetsFilenames(request)) || (await fetch(request))
    )
}

async function handleSemanticAssetsFilenames(request) {
    const re = /^https:\/\/assets.serlo.org\/(legacy\/|)(\w+)\/([\w\-\+]+)\.(\w+)$/
    const match = request.url.match(re)

    if (!match) {
        return null
    }

    const [_url, prefix, hash, name, extension] = match
    return await fetch(
        `https://assets.serlo.org/${prefix}${hash}.${extension}`,
        request
    )
}
