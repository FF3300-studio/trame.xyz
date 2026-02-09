module.exports = {
  plugins: [
    require('@fullhuman/postcss-purgecss')({
      content: [
        './site/**/*.php',
        './site/**/*.yml',
        './assets/src/js/**/*.js'
      ],
      defaultExtractor: content => content.match(/[\w-/:]+(?<!:)/g) || [],
      safelist: {
        standard: [
          /^swiper-/,
          /^lenis/,
          'active',
          'show',
          'collapsed',
          'collapsing',
          'data-lenis-prevent',
          'footer',
          'group-footer',
          'footer_nav',
          'credits',
          'spin-offs',
          'social'
        ],
        deep: [
          /^display-/,
          /^margin-/,
          /^padding-/,
          /^text-/,
          /^bg-/
        ],
        button: [/^swiper-/] // Ensures button states for swiper are kept
      }
    })
  ]
}
