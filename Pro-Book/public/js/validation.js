const validation = {
  required(attr) {
    const tests = [
      'el.value === \'\'',
    ];

    return this.resolve(attr, tests, ' is required');
  },

  email(attr) {
    const pattern = /^[a-zA-Z0-9.!#$%&’*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
    const tests = [
      `!${pattern}.test(String(el.value).toLowerCase())`,
    ];

    return this.resolve(attr, tests, ' is not valid.');
  },

  digit(attr) {
    const pattern = /^[0-9]+$/;
    const tests = [
      `!${pattern}.test(String(el.value).toLowerCase())`,
    ];

    return this.resolve(attr, tests, ' must be a number.');
  },

  phone(attr) {
    let valid = this.digit(attr);
    if (valid.result) {
      valid = this.betweenLen(attr, 9, 12);
    }

    return {
      result: valid.result,
      message: valid.message,
    };
  },

  password(attr) {
    if (attr[0].value !== attr[1].value) {
      return {
        result: false,
        message: 'Password doesn\'t match.',
      };
    }

    return {
      result: true,
      message: 'OK',
    };
  },

  minVal(attr, minVal) {
    const tests = [
      `(el.value >= ${minVal})`,
    ];

    return this.resolve(attr, tests, ` must be greater or equal to ${minVal}`);
  },

  maxVal(attr, maxVal) {
    const tests = [
      `(el.value <= ${maxVal})`,
    ];

    return this.resolve(attr, tests, ` must be less than or equal to ${maxVal}`);
  },

  betweenVal(attr, minVal, maxVal) {
    const tests = [
      `!(el.value >= ${minVal})`,
      `!(el.value <= ${maxVal})`,
    ];

    return this.resolve(attr, tests, ` must have minimum value of ${minVal} and maximum value of ${maxVal}`);
  },

  minLen(attr, minLen) {
    const tests = [
      `!(String(el.value).length >= ${minLen})`,
    ];

    return this.resolve(attr, tests, ` must have minimum length of ${minLen}`);
  },

  maxLen(attr, maxLen) {
    const tests = [
      `!(String(el.value).length <= ${maxLen})`,
    ];

    return this.resolve(attr, tests, ` must have maximum length of ${maxLen}`);
  },

  betweenLen(attr, minLen, maxLen) {
    const tests = [
      `!(String(el.value).length >= ${minLen})`,
      `!(String(el.value).length <= ${maxLen})`,
    ];

    return this.resolve(attr, tests, ` must have minimum length of ${minLen} and maximum length of ${maxLen}`);
  },

  resolve(attr, tests, message) {
    let valid = true;
    const invalidAttr = [];
    attr.forEach((el) => {
      tests.forEach((test) => {
        if (eval(test)) {
          if (!invalidAttr.includes(el.getAttribute('name'))) {
            invalidAttr.push(el.getAttribute('name'));
          }
          valid = false;
        }
      });
    });

    return {
      result: valid,
      message: (invalidAttr.length === 0) ? 'OK' : `${invalidAttr} ${message}`,
    };
  },

  display(message) {
    const alertBox = document.getElementsByClassName('alert-box')[0];

    if (alertBox != null) {
      document.body.removeChild(alertBox);
    }

    const div = document.createElement('div');
    div.className = 'alert-box';
    div.innerHTML = `<span class="close-btn" onclick="this.parentElement.style.display='none';">&times;</span><p> ${message} </p>`;
    document.body.insertBefore(div, document.getElementsByClassName('container')[0]);
    div.style.top = '0';
  },
};
