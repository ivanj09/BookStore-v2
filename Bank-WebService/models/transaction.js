'use strict';
module.exports = (sequelize, DataTypes) => {
  var Transaction = sequelize.define('Transaction', {
    sender_card: DataTypes.INT,
    receiver_card: DataTypes.INT,
    amount: DataTypes.FLOAT,
    transaction_time: DataTypes.TIMESTAMP
  }, {});
  Transaction.associate = function(models) {
    // associations can be defined here
    Transaction.belongsTo(models.Account, {
      foreignKey: 'sender_card',
      targetKey: 'card_number'
    });

    Transaction.belongsTo(models.Account, {
      foreignKey: 'receiver_card',
      targetKey: 'card_number'
    });
  };
  return Transaction;
};