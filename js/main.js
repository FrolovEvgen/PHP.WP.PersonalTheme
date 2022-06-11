/* 
 * The MIT License
 *
 * Copyright 2020 E.Frolov <frolov@amiriset.com>.
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */

/**
 * Utility methods.
 * 
 * @type {Utils}
 */
var Utils = {
    // Total count of generated object.
    _totalEl: 0,

    /**
     * Generates new Id.
     * 
     * @param {String} id  - Base ID.
     * 
     * @returns {String} - Generated new ID with counter;
     */
    generateId: function(id) {
        return (id + '_' + this._totalEl++);
    },

    /**
     * Creates HTML element.
     * 
     * @param {String} className HTML tag class.
     * @param {String} id (optional) HTML element ID.
     * 
     * @returns {HTMLElement}
     */
    createEl: function(className, id) {        
        className = className || "div";
        // Create an element.
        var element = document.createElement(className);
        // Set its ID.
        element.id = id || this.generateId(className);
        return element;
    }
};

/**
 * Switch class on linked target.
 * 
 * @param {event} e EventClick
 * 
 * @returns {undefined}
 */
var toggleClass = function(e) {
    var dataSet = e.target.dataset,
        htmlElement = document.getElementById(dataSet.item);
		
    if (null !== htmlElement) {
        var classList = htmlElement.classList,
            cls = dataSet.class;
		
        if (classList.contains(cls)) {
            classList.remove(cls);
        } else {
            classList.add(cls);
        }
    }
};

/**
 * Generates src array from srcset attribute.
 * 
 * @param {String} srcset 'srcset' Img attribute.
 * 
 * @returns {Array} Arrey of sources.
 */
var srcGenerator = function(srcset) {
    var arr = srcset.split(',');
    var result = [];
    arr.forEach(function(value){
        var obj = {};
        obj.src = value.replace(/(\s\d+w)$/, '');
        obj.width = value.replace(obj.src, '').replace('w', '');
        result.push(obj);
    });
    return (result);
};

/**
 * Show modal window with image.
 * 
 * @param {type} e On click event.
 * 
 * @returns {undefined}
 */
var showModal = function(e) {
    var target = e.currentTarget,
        targetImg = target.querySelector("img"),
        targetCaption = target.querySelector("p"),
        overflow = document.body.style.overflow,
	wratio = document.querySelector(".container").offsetWidth / window.screen.width;
	
    document.body.style.overflow = "hidden";
	
    // Creates modal body.
    var modal = Utils.createEl("div", "image_view");
    modal.classList.add("modal");
	
    var cover = Utils.createEl("div");
    cover.classList.add("cover");
    cover.classList.add("container");
    modal.appendChild(cover);
    
    // Create header.
    var header = Utils.createEl("div");
    header.classList.add("modal_header");
    cover.appendChild(header);
    
    // Create 'Cancel' button.
    var cancelButton = Utils.createEl("button");
    cancelButton.classList.add("cancel");
    cancelButton.innerText= " X ";
    cancelButton.onclick = function(e) {
        document.body.removeChild(modal);
        document.body.style.overflow = overflow;
    };
    header.appendChild(cancelButton);
	
    // Creates modal content container.
    var content = Utils.createEl("div");
    content.classList.add("modal_content");	
    cover.appendChild(content);
	
    // Add header.
    var head3 = Utils.createEl("h3");
    head3.innerText = targetImg.alt;
    content.appendChild(head3);
	
    // Add image container.
    var imgContainer = Utils.createEl();
    imgContainer.classList.add("image");	
    content.appendChild(imgContainer);
	
    // Creates image view.
    var imgSrc = Utils.createEl("img");
    
    // Get source.
    var srcArray = srcGenerator(targetImg.srcset);
    imgSrc.src = srcArray[1].src;
    
    // Set dimensions.
    if (targetImg.offsetWidth > targetImg.offsetHeight) {
        imgSrc.style.width = Math.floor(window.screen.width * wratio * 0.9) + "px";
        imgSrc.style.height = "auto";
    } else {
        imgSrc.style.height = Math.floor(window.screen.height * wratio * 0.9) + "px";
        imgSrc.style.width = "auto";	
    }	
    imgContainer.appendChild(imgSrc);
	
    var caption = Utils.createEl("p");
    caption.innerText = targetCaption.innerText;
    content.appendChild(caption);
	
    document.body.appendChild(modal);
};