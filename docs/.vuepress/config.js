module.exports = {
  locales: {
    '/': {
      lang: 'en-CA',
      title: 'Writedown',
      description: 'Writedown integrate popular markdown parsers inside the blade template engine by enabling markdown "curly" braces, directives and / or views.'
    }
    // TO-DO French
    // '/fr/': {
    //   lang: 'fr-CA',
    //   title: 'Writedown',
    //   description: 'Writedown integrate popular markdown parsers inside the blade template engine by enabling markdown "curly" braces, directives and / or views.'
    // }
  },
  head: [
    ['link', { rel: 'icon', href: '/icons/android-chrome-192x192.png' }],
    ['link', { rel: 'manifest', href: '/manifest.json' }],
    ['meta', { name: 'theme-color', content: '#ff4c00' }],
    ['meta', { name: 'apple-mobile-web-app-capable', content: 'yes' }],
    ['meta', { name: 'apple-mobile-web-app-status-bar-style', content: 'black' }],
    ['link', { rel: 'apple-touch-icon', href: `/icons/apple-touch-icon-152x152.png` }],
    ['link', { rel: 'mask-icon', href: '/icons/safari-pinned-tab.svg', color: '#ff4c00' }],
    ['meta', { name: 'msapplication-TileImage', content: '/icons/msapplication-icon-144x144.png' }],
    ['meta', { name: 'msapplication-TileColor', content: '#000000' }],
    ['link', { rel: 'stylesheet', href: 'https://fonts.googleapis.com/css?family=Quicksand:300,400,700|Titillium+Web' }]
  ],
  serviceWorker: true,
  themeConfig: {
    repo: 'haleks/writedown',
    editLinks: true,
    lastUpdated: true,
    docsDir: 'docs',
    locales: {
      '/': {
        label: 'English',
        selectText: 'Languages',
        editLinkText: 'Edit this page on GitHub',
        lastUpdated: 'Last Updated',
        nav: [
          {
            text: 'Guide',
            items: [
              { text: 'Latest', link: '/latest/guide/' },
              { text: 'v2.1', link: '/v2.1/guide/' },
              { text: 'v2.0', link: '/v2.0/guide/' },
              { text: 'v1.0', link: '/v1.0/guide/' }
            ]
          }
        ],
        sidebar: {
          '/latest/guide/': sidebar({
            title: 'Guide',
            children: [
              '',
              'configuration',
              'how-to-use'
            ]
          }),
          '/v2.1/guide/': sidebar({
            title: 'Guide',
            children: [
              '',
              'configuration',
              'how-to-use'
            ]
          }),
          '/v2.0/guide/': sidebar({
            title: 'Guide',
            children: [
              '',
              'configuration',
              'how-to-use'
            ]
          }),
          '/v1.0/guide/': sidebar({
            title: 'Guide',
            children: [
              '',
              'configuration',
              'how-to-use'
            ]
          })
        }
      },
      // TO-DO French
      // '/fr/': {
      //   label: 'Français',
      //   selectText: 'Langues',
      //   editLinkText: 'Modifier sur GitHub',
      //   lastUpdated: 'Dernière mise à jour',
      //   nav: [
      //     { text: 'Guide', link: '/fr/guide/' }
      //   ],
      //   sidebar: {
      //     '/fr/guide/': sidebar({
      //       title: 'Guide',
      //       children: [
      //         '',
      //         'configuration',
      //         'how-to-use'
      //       ]
      //     })
      //   }
      // }
    }
  }
}

function sidebar ({ title, children }) {
  return [
    {
      title,
      collapsable: false,
      children
    }
  ]
}
