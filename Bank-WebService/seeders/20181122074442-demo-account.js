'use strict';

module.exports = {
  up: (queryInterface, Sequelize) => {
    /*
      Add altering commands here.
      Return a promise to correctly handle asynchronicity.

      Example:
      return queryInterface.bulkInsert('Person', [{
        name: 'John Doe',
        isBetaMember: false
      }], {});
    */
    return queryInterface.bulkInsert('Accounts', [
      {
        card_number: 123123123,
        name: 'Rafli',
        balance: 1000,
        createdAt: new Date(),
        updatedAt: new Date(),
      }, {
        card_number: 321321321,
        name: 'Tayo',
        balance: 10,
        createdAt: new Date(),
        updatedAt: new Date(),
      },
    ])
  },

  down: (queryInterface, Sequelize) => {
    return queryInterface.bulkDelete('Accounts', null, {});
  }
};
