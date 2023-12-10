tocbot.init({
    // Where to render the table of contents.
    tocSelector: '.toc',
    // Where to grab the headings to build the table of contents.
    contentSelector: '.entry-content',
    // Which headings to grab inside of the contentSelector element.
    headingSelector: 'h2, h3',
    // For headings inside relative or absolute positioned containers within content.
    scrollSmooth: true,
    headingsOffset: 40,
    scrollSmoothOffset: -40,
    hasInnerContainers: true
  });