# Workshop CSS — Corrigé pédagogique

**Boucle : Mise en page, responsive et fondamentaux CSS**

## 1. Cadre pédagogique et recommandations

### Prérequis

Ce workshop s’inscrit dans la continuité de la **corbeille d’exercices de la boucle**.
Celle-ci doit impérativement être réalisée **en amont**, afin que les étudiants maîtrisent déjà :

* la structure HTML de base,
* la notion de balise, d’attribut et de hiérarchie du DOM.

### Outils de développement

Il est essentiel d’insister sur l’utilisation des **outils de développement du navigateur** (DevTools).

Dans le cadre de cette boucle, seuls deux onglets sont réellement exploités :

* **Éléments (Elements)** : inspection du DOM, compréhension de la structure HTML, règles CSS appliquées.
* **Réseau (Network)** : chargement des ressources (CSS, images), diagnostic d’erreurs de liens.

Une démonstration en direct est fortement recommandée pour montrer :

* l’arborescence HTML,
* l’origine des styles appliqués,
* la surcharge de règles CSS.

### Contraintes pédagogiques

* La **mise en page des blocs doit obligatoirement utiliser Flexbox**, cette notion faisant partie des AAVs évalués dans la boucle.
* Les solutions proposées dans le corrigé sont **des exemples**, non des réponses uniques ou obligatoires.

---

## 2. Q1 — Méthodes pour ajouter du CSS à un document HTML

Il existe **trois méthodes principales** pour appliquer des styles CSS à une page HTML.

### 1. Style en ligne (inline)

Les styles sont définis directement dans l’attribut `style` d’une balise HTML.

```html
<p style="color: red; font-size: 14px;">
  Texte stylisé en ligne
</p>
```

👉 **À éviter** sauf cas très particuliers (tests rapides, surcharge ponctuelle).

---

### 2. Style interne (dans l’en-tête)

Les règles CSS sont définies dans une balise `<style>` placée dans le `<head>` du document.

```html
<head>
  <style>
    p {
      color: blue;
    }
  </style>
</head>
```

👉 Utile pour des prototypes, mais peu maintenable à long terme.

---

### 3. Feuille de style externe (méthode recommandée)

Les styles sont placés dans un fichier `.css` séparé, lié au document HTML.

```html
<head>
  <link rel="stylesheet" href="style.css">
</head>
```

👉 **Méthode à privilégier** : meilleure lisibilité, maintenabilité et réutilisabilité.

---

## 3. Q2 — Les différents types de sélecteurs CSS

Les sélecteurs permettent de cibler les éléments HTML auxquels appliquer des règles CSS.

### Principaux types de sélecteurs

```css
h1 { }              /* Sélecteur de type */
.box { }            /* Sélecteur de classe */
#unique { }         /* Sélecteur d'identifiant */
a[title] { }        /* Sélecteur d’attribut */
a:hover { }         /* Pseudo-classe */
article > p { }     /* Sélecteur combiné */
```

### À retenir

* Les classes sont **réutilisables**.
* Les ID doivent être **uniques dans la page**.
* Les pseudo-classes décrivent un **état** (survol, focus, actif…).
* Les combinateurs permettent un ciblage précis dans la hiérarchie du DOM.

---

## 4. Q3 — Gestion des priorités CSS (spécificité)

Lorsque plusieurs règles CSS ciblent le même élément, le navigateur applique une logique de priorité.

### Ordre de priorité (du plus fort au plus faible)

1. **Style en ligne** (`style=""`)
2. **Sélecteurs d’ID** (`#id`)
3. **Classes, attributs et pseudo-classes** (`.class`, `[attr]`, `:hover`)
4. **Sélecteurs de type et pseudo-éléments** (`p`, `div`, `::before`)

👉 Plus un sélecteur est précis, plus il est prioritaire.

---

## 5. Q4 — Unités de mesure pour le texte

### Unités courantes

* `px` — pixels
* `%` — pourcentage
* `em` — relatif à l’élément parent
* `rem` — relatif à la racine (`html`)
* `vw` / `vh` — pourcentage de la largeur / hauteur de l’écran
* `vmin` / `vmax` — minimum / maximum entre largeur et hauteur

### Bonnes pratiques

* Éviter les unités physiques (`cm`, `mm`, `pt`, `in`)
* **Privilégier `em`, `rem`, `vw`, `vh`** pour le responsive design
* `rem` est généralement préféré pour une cohérence globale

---

## 6. Q5 — Méthodes de positionnement des blocs

### 1. Float (méthode historique)

```css
.left {
  float: left;
}

.right {
  float: right;
}
```

👉 Peu intuitive, nécessite `clear`, **à éviter dans les nouveaux projets**.

---

### 2. Flexbox (méthode recommandée)

```html
<div class="flex-container">
  <div class="flex-child">Colonne 1</div>
  <div class="flex-child">Colonne 2</div>
</div>
```

```css
.flex-container {
  display: flex;
}

.flex-child {
  flex: 1;
}

.flex-child:first-child {
  margin-right: 20px;
}
```

👉 Simple, moderne, parfaitement adaptée aux layouts responsives.

---

### 3. CSS Grid

```css
.grid-container {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 20px;
}
```

👉 Très puissante pour des mises en page complexes.

---

## 7. Q6 — Media queries (responsive design)

Les **media queries** permettent d’appliquer des styles selon :

* le type d’appareil,
* la taille de l’écran,
* certaines caractéristiques (orientation, résolution…).

```css
.text {
  font-size: 14px;
}

@media (max-width: 480px) {
  .text {
    font-size: 16px;
  }
}
```

👉 Les media queries doivent être **placées en fin de fichier CSS**.

---

## 8. Q7 — Types de médias

* `all` — tous les appareils
* `screen` — écrans
* `print` — impression
* `speech` — lecteurs d’écran

```css
@media screen and (max-width: 480px) {
  .text {
    font-size: 16px;
  }
}
```

---

## 9. Q8 — Breakpoints usuels

Il n’existe pas de valeurs officielles, mais des **fourchettes courantes** :

| Type d’équipement  | Largeur approximative |
| ------------------ | --------------------- |
| Mobile             | 320px – 480px         |
| Tablette           | 481px – 768px         |
| Laptop             | 769px – 1024px        |
| Desktop            | 1025px – 1200px       |
| Très grands écrans | 1201px et +           |

---

## 10. Conclusion pédagogique

Le code CSS fourni dans ce corrigé :

* **répond aux objectifs du workshop**,
* constitue **un exemple parmi d’autres**,
* laisse volontairement place à la créativité et à l’expérimentation.

👉 Toute solution respectant les contraintes techniques et pédagogiques est recevable.
