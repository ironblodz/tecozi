import { createI18n } from 'vue-i18n';

// Criar instância do i18n
const i18n = createI18n({
  locale: 'pt',  // Idioma padrão
  allowComposition: true,  // Permitir a API de composição no Vue 3
  messages: {
   en: {
  buttoncategory: {
    title: "All",
    title1: "Kitchens",
    title2: "Wardrobes",
    title3: "Closets",
    title4: "Accessories",
  },
  carrousel: {
    carrousel: "Custom Kitchens and Wardrobes",
    carrouselp: "We provide a personalized project perspective tailored to each space.",
    readmore: "Learn more",
    carrousel2: "We work with the best brands in the world",
    carrousel2p: "Quality work combined with the finest materials in every project we undertake.",
    carrousel3: "Each project is unique!",
    carrousel3p: "We tailor the project to meet each client's requirements.",
    carrousel4: "Shall we talk?",
    carrousel5: "For any doubts or questions, don't hesitate to contact us.",
  },
  projectdone: {
    paragraph: "At Tecozi, we stay up-to-date with current trends to offer the best solutions at the best price.",
    title: "From Concept to Project",
    titlev2: "Completion",
    visite: "Initial Visit",
    visitep: "After contact, we schedule a first site visit to take measurements and understand the client's ideas.",
    project: "Project and Budget",
    projectp: "We prepare and present the 3D project (planning) and materials. Subsequently, we provide a tailored proposal.",
    retification: "Rectification",
    retificationp: "After approval, we revisit the site to finalize all measurements.",
    execution: "Execution and Installation",
    executionp: "Once all details and deadlines are agreed upon, we produce and install as planned.",
    finishes: "Finishes",
    finishesp: "We ensure meticulous finishing on every project for the best results.",
    sells: "After-Sales",
    sellsp: "We provide after-sales service for better follow-up.",
  },
  projectsfeactures: {
    projects: "Featured",
    projectscc: "Projects",
    projectsp: "The focus of Tecozi LDA Kitchens is to expertly create custom Kitchens and Wardrobes.<br> We have a vast portfolio of works that tell our story over the years.",
    kitchen: "Kitchens",
    wardrobes: "Wardrobes",
    closets: "Closets",
    others: "Others",
  },
  contact: {
  title: "Contact Us",
  description: "Turn dreams into reality! Don't hesitate to contact us. <br> Shall we talk?",
  button: "Contact"
},
quote: {
  text: '"Everything worth doing is worth doing well."',
  author: "—Philip Stanhope"
}

},
  pt: {
    buttoncategory: {
    title: "Todos",
    title1: "Cozinhas",
    title2: "Roupeiros",
    title3: "Closets",
    title4: "Acessórios",
    },
    carrousel: {
        carrousel:"Cozinhas e Roupeiros por medida",
        carrouselp:"Apresentamos uma perspectiva personalizada do projeto adaptada a cada espaço",
        readmore: "Saber mais",
        carrousel2:"Trabalhamos com as melhores marcas do mundo",
        carrousel2p:"Trabalho de qualidade acompanhado dos melhores materiais em cada projeto realizado",
        carrousel3: "Cada projeto é único!",
        carrousel3p: "Adequamos o projeto às exigências de cada cliente.",
        carrousel4: "Vamos falar?",
        carrousel5: "Qualquer dúvida ou questão não hesite em contactar-nos",
    },
    projectdone: {
        paragraph: "Na Tecozi estamos atentos às tendências atuais para oferecer a melhor solução ao melhor preço.",
        title:"Do Conceito à Conclusão do",
        titlev2:"Projeto",
        visite: "Visita Inicial",
        visitep: "Após contacto, combinamos uma primeira visita à obra para recolher medidas e as ideias do cliente.",
        project: "Projeto e Orçamento",
        projectp: "Efetuamos e apresentamos o projeto 3D(planeamento) e os materias. Posteriormente orçamentamos uma proposta personalizada.",
        retification: "Retificação",
        retificationp: " Após a adjudicação voltamos à obra para retificar todas as medidas.",
        execution: "Execução e Instalação",
        executionp: "Após definir todos os pormenores e prazos, realizamos e instalamos conforme combinado.",
        finishes:"Acabamentos",
        finishesp:"Realizamos acabamentos cuidados em cada obra para um melhor resultado.",
        sells: "Pós-Venda",
        sellsp: "Asseguramos um serviço pós-venda para um melhor acompanhamento.",
    },
    projectsfeactures: {
        projects: "Projetos em",
        projectscc: " Destaque",
        projectsp: "O foco das Cozinhas Tecozi LDA é realizar com sabedoria móveis de Cozinha e Roupeiros por medida.<br> Temos um vasto portfólio de trabalhos que contam a nossa história ao longo dos anos.",
        kitchen: "Cozinhas",
        wardrobes: "Roupeiros",
        closets: "Closets",
        others: "Outros",
    },
    contact: {
      title: "Contacte-nos",
      description: "Torne os sonhos realidade! Não hesite em entrar em contacto connosco. <p>Vamos conversar?</p>",
      button: "Contactar"
    },
    quote: {
      text: '"Tudo o que vale a pena ser feito, vale a pena ser bem feito."',
      author: "—Philip Stanhope"
    }
  },
  fr: {
  buttoncategory: {
    title: "Tous",
    title1: "Cuisines",
    title2: "Armoires",
    title3: "Dressing",
    title4: "Accessoires",
  },
  carrousel: {
    carrousel: "Cuisines et armoires sur mesure",
    carrouselp: "Nous proposons une perspective de projet personnalisée adaptée à chaque espace.",
    readmore: "En savoir plus",
    carrousel2: "Nous travaillons avec les meilleures marques au monde",
    carrousel2p: "Un travail de qualité associé aux meilleurs matériaux pour chaque projet réalisé.",
    carrousel3: "Chaque projet est unique !",
    carrousel3p: "Nous adaptons le projet aux exigences de chaque client.",
    carrousel4: "On discute ?",
    carrousel5: "Pour toute question ou doute, n'hésitez pas à nous contacter.",
  },
  projectdone: {
    paragraph: "Chez Tecozi, nous suivons les tendances actuelles pour offrir la meilleure solution au meilleur prix.",
    title: "Du concept à la réalisation",
    titlev2: "du projet",
    visite: "Visite initiale",
    visitep: "Après contact, nous planifions une première visite sur place pour prendre des mesures et comprendre les idées du client.",
    project: "Projet et budget",
    projectp: "Nous préparons et présentons le projet 3D (planification) et les matériaux. Ensuite, nous proposons une offre personnalisée.",
    retification: "Rectification",
    retificationp: "Après approbation, nous revisitons le site pour finaliser toutes les mesures.",
    execution: "Exécution et installation",
    executionp: "Une fois tous les détails et délais convenus, nous réalisons et installons comme prévu.",
    finishes: "Finitions",
    finishesp: "Nous assurons des finitions soignées pour chaque projet pour un meilleur résultat.",
    sells: "Service après-vente",
    sellsp: "Nous assurons un service après-vente pour un meilleur suivi.",
  },
  projectsfeactures: {
    projects: "Projets en",
    projectscc: "vedette",
    projectsp: "L'objectif des cuisines Tecozi LDA est de créer avec expertise des cuisines et armoires sur mesure.<br> Nous avons un vaste portfolio de travaux qui raconte notre histoire au fil des années.",
    kitchen: "Cuisines",
    wardrobes: "Armoires",
    closets: "Dressing",
    others: "Autres",
  },
  contact: {
  title: "Contactez-nous",
  description: "Réalisez vos rêves ! N'hésitez pas à nous contacter. <br> Discutons ensemble ?",
  button: "Contacter"
},
quote: {
  text: '"Tout ce qui mérite d’être fait mérite d’être bien fait."',
  author: "—Philip Stanhope"
}

}

  }
});

export default i18n;
